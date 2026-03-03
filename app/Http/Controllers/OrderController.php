<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ProductOffer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(){ // TODO: que se muestre la fecha de entrega
        $orders = Order::where("user_id", Auth::id())->with("products.productOffer.product")->get()->reverse();
        $offerProducts = ProductOffer::with("product")->get()->keyBy("id");

        return view("auth.orders", compact("orders", "offerProducts"));
    }
}
