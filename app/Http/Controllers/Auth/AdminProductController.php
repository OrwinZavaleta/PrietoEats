<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $products = Product::where("date", ">", new \DateTime())->get() ?? [];
        $products = Product::all()->reverse() ?? [];

        return view("admin.products", compact("products"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("admin.createProduct");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "nombre" => "required|string",
            "precio" => "required|numeric",
            "descripcion" => "required|string",
            "imagen" => "image|mimes:jpeg,png,jpg,gif|max:2048"
        ]);
        if ($request->hasFile("imagen")) {
            $path = $request->file("imagen")->store("img", "public");
        }

        Product::create([
            "name" => $request->nombre,
            "description" => $request->descripcion,
            "price" => $request->precio,
            "image" => $path ?? null,
        ]);

        return redirect()->route("admin.products.index")->with("success", "Se creó el producto exitosamente");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $plato = Product::findOrFail($id);
            return view("admin.editProduct", compact("plato"));
        } catch (\Exception $e) {
            return back()->with("error", "El producto seleccionado no existe.");
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            "nombre" => "required|string",
            "precio" => "required|numeric",
            "descripcion" => "required|string",
            "imagen" => "image|mimes:jpeg,png,jpg,gif|max:2048"
        ]);
        if ($request->hasFile("imagen")) {
            $path = $request->file("imagen")->store("img", "public");
        }

        $plato = Product::find($id);

        $plato->name = $validated["nombre"] ?? $plato["nombre"];
        $plato->description = $validated["descripcion"] ?? $plato["descripcion"];
        $plato->price = $validated["precio"] ?? $plato["precio"];
        $plato->image = $path ?? $plato["image"];

        $plato->save();

        return redirect()->route("admin.products.index")->with("success", "Se creó el producto exitosamente");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Product::destroy($id);
        return back()->with("success", "Se borro el producto exitosamente");
    }
}
