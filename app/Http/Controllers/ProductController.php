<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\Product;
use App\Models\ProductOffer;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function home()
    {
        // $menus = Product::where("product_type", "menu")->where("date", ">", new DateTime())->get() ?? [];
        // $dishes = Product::with("offers")->whereHas('offers', function ($query) {
        //     $query->where("datetime_limit", ">", now());
        // })->get()->reverse() ?? [];

        // $dishes = ProductOffer::with(["product", "offer"])->get()->reverse() ?? [];
        $ofertas = Offer::with("productsOffer.product")->where("date_delivery", ">", now())->orderBy("date_delivery")->get() ?? [];
        // dd($ofertas);
        return view("home", compact("ofertas"));
    }
}
