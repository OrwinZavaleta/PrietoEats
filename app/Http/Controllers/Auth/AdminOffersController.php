<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductOffer;
use App\Models\ProductOrder;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminOffersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $offers = Offer::with("productsOffer.product")->get()->reverse() ?? [];

        return view("admin.offers", compact("offers"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $platos = Product::all();
        return view("admin.createOffer", compact("platos"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "date_delivery" => "required|date",
            "time_delivery" => "required|string",
            "platosSeleccionados" => "required|array",
            "platosSeleccionados.*" => "exists:products,id",
        ]);

        DB::transaction(function () use ($request) {
            $ofertaCreada = Offer::create([
                "date_delivery" => $request->date_delivery,
                "time_delivery" => $request->time_delivery,
            ]);

            for ($i = 0; $i < count($request->platosSeleccionados); $i++) {

                ProductOffer::create([
                    "offer_id" => $ofertaCreada->id,
                    "product_id" => $request->platosSeleccionados[$i],
                ]);
            }
        });

        return redirect()->route("admin.offers.index")->with("success", "Se agregó la oferta exitosamente");
    }

    /**
     * Display the specified resource.
     * Para mostrar los platos pedidos en cada oferta
     */
    public function show(string $id)
    {
        $offer = Offer::with('productsOffer.product')->findOrFail($id);

        $productOrders = ProductOrder::with(['order.user', 'productOffer.product'])
            ->whereHas('productOffer', function ($query) use ($id) {
                $query->where('offer_id', $id);
            })->get();

        $reportData = [];

        foreach ($productOrders as $po) {
            $user = $po->order->user;
            $product = $po->productOffer->product;
            $qty = $po->quantity;

            if (!isset($reportData[$user->id])) {
                $reportData[$user->id] = [
                    'user_name' => $user->name,
                    'totals' => [] 
                ];
            }

            if (!isset($reportData[$user->id]['totals'][$product->id])) {
                $reportData[$user->id]['totals'][$product->id] = 0;
            }
            $reportData[$user->id]['totals'][$product->id] += $qty;
        }

        return view("admin.offerAdminOrder", compact('offer', 'reportData'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Offer::destroy($id);

        return back()->with("success", "Se borro la oferta exitosamente");
    }
}
