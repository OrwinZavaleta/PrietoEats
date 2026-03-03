<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Offer;
use App\Models\ProductOffer;
use App\Models\Order;
use App\Models\ProductOrder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        // Asegurarnos de tener usuarios, ofertas y productos_oferta
        $users = User::all();
        $offers = Offer::with('productsOffer.product')->get();

        if ($users->isEmpty() || $offers->isEmpty()) {
            return;
        }

        // Crear pedidos manuales y consistentes
        // Recorremos algunas ofertas para crear pedidos en ellas
        foreach ($offers as $offer) {
            // Solo creamos pedidos para algunas ofertas aleatoriamente (o todas)
            // Simulamos que 3 usuarios compran en cada oferta
            $randomUsers = $users->random(min(3, $users->count()));

            foreach ($randomUsers as $user) {
                // Seleccionar productos de esta oferta específica
                $availableProductOffers = $offer->productsOffer;
                
                if ($availableProductOffers->isEmpty()) {
                    continue;
                }

                // El usuario compra entre 1 y 3 productos distintos de esta oferta
                $selectedProductOffers = $availableProductOffers->random(min(rand(1, 3), $availableProductOffers->count()));
                
                $totalOrder = 0;
                $orderItems = [];

                foreach ($selectedProductOffers as $po) {
                    $quantity = rand(1, 2); // Cantidad de este plato
                    $price = $po->product->price;
                    $subtotal = $price * $quantity;
                    $totalOrder += $subtotal;

                    $orderItems[] = [
                        'product_offer_id' => $po->id,
                        'quantity' => $quantity,
                    ];
                }

                // Crear la Orden
                $orderId = DB::table('orders')->insertGetId([
                    'user_id' => $user->id,
                    'total' => $totalOrder,
                    'created_at' => $offer->created_at, // Simulamos que se pidió cuando se creó la oferta o cerca
                    'updated_at' => $offer->updated_at,
                ]);

                // Crear los items de la orden (ProductOrder)
                foreach ($orderItems as $item) {
                    DB::table('product_orders')->insert([
                        'order_id' => $orderId,
                        'product_id' => $item['product_offer_id'], // OJO: la columna se llama product_id pero apunta a product_offers según tu esquema
                        'quantity' => $item['quantity'],
                        'created_at' => $offer->created_at,
                        'updated_at' => $offer->updated_at,
                    ]);
                }
            }
        }
    }
}
