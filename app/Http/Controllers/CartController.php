<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\ProductOffer;
use App\Models\Offer;
use App\Models\ProductOrder;
use Illuminate\Http\Request;

class CartController extends Controller
{
    private $LIMITE_RESERVA_POR_PRODUCTO = 5;

    public function index()
    {
        $cart = session()->get("cart", []);

        if (empty($cart)) {
            return view("auth.cart", [
                "cart" => [],
                "offersById" => collect(),
                "productOffersById" => collect(),
            ]);
        }


        $offerIds = array_keys($cart);

        $productOfferIds = [];

        foreach ($cart as $offerId => $items) {
            $productOfferIds = array_merge($productOfferIds, array_keys($items));
        }

        $productOfferIds = array_unique($productOfferIds);

        $offersById = Offer::whereIn("id", $offerIds)
            ->get(["id", "date_delivery", "time_delivery"])
            ->keyBy("id");

        $productOffersById = ProductOffer::with("product")
            ->whereIn("id", $productOfferIds)
            ->get(["id", "offer_id", "product_id"])
            ->keyBy("id");

        return view("auth.cart", compact("cart", "offersById", "productOffersById"));
    }

    public function add($idProductOffer)
    {
        $productOffer = null;
        try {
            $productOffer = ProductOffer::findOrFail($idProductOffer);
        } catch (\Exception $e) {
            return back()->with("error", "No se encontro el producto.");
        }

        $cart = session()->get("cart", []);
        if (!isset($cart[$productOffer->offer_id][$productOffer->id])) {
            $cart[$productOffer->offer_id][$productOffer->id] = 1;
        } else {
            $cart[$productOffer->offer_id][$productOffer->id]++;
        }
        session()->put("cart", $cart);

        return redirect()->route("home")->with("success", "Producto añadido correctamente.");
    }

    public function delete($offerId, $productOfferId)
    {
        $cart = session()->get("cart", []);

        if (isset($cart[$offerId][$productOfferId])) {
            unset($cart[$offerId][$productOfferId]);
        }

        if (count($cart[$offerId]) == 0) {
            unset($cart[$offerId]);
        }

        session()->put("cart", $cart);

        return back()->with("success", "Se eliminó el producto correctamente de su carrito.");
    }

    public function destroy()
    {
        session()->forget("cart");

        return back()->with("success", "Se vació correctamente el carrito.");
    }

    // Quiza esto es mejor hacerlo con js. Habrian muchos recargos de página.
    public function increase($offerId, $productOfferId)
    {
        $cart = session()->get("cart", []);

        if (isset($cart[$offerId][$productOfferId]) && $cart[$offerId][$productOfferId] < $this->LIMITE_RESERVA_POR_PRODUCTO) {
            $cart[$offerId][$productOfferId]++;
        }

        session()->put("cart", $cart);

        return redirect()->route("cart.index");
    }
    public function decrease($offerId, $productOfferId)
    {
        $cart = session()->get("cart", []);

        if (isset($cart[$offerId][$productOfferId]) && $cart[$offerId][$productOfferId] > 1) {
            $cart[$offerId][$productOfferId]--;
        }

        session()->put("cart", $cart);

        return redirect()->route("cart.index");
    }

    public function order()
    {
        $cart = session()->get("cart", []);

        session()->forget("cart");

        foreach ($cart as $offerId => $items) {
            $precioTotal = 0;
            $order = Order::create([
                "user_id" => Auth::id(),
                "total" => 0,
            ]);
            foreach ($items as $poId => $quantity) {
                try {
                    $productOffer = ProductOffer::with("product")->findOrFail($poId);
                } catch (\Exception $e) {
                    return back()->with("error", "Un producto no encontrado.");
                }
                $precioTotal += $quantity * $productOffer->product["price"];
                ProductOrder::create([
                    "order_id" => $order->id,
                    "product_id" => $productOffer->id,
                    "quantity" => $quantity,
                ]);
            }
            $order->total = $precioTotal;
            $order->save();
        }


        return redirect()->route("home")->with("success", "Su reserva se realizó correctamente.");
    }
}
