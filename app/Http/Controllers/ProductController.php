<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $product = Product::get()->take(5);

        dd($product);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $request = [
            'supplier_id' => 1,
            'name' => 'Luva Cirúrgica Estéril',
            'price' => 'R$89.90',
            'type' => 'MEDICAL',
            'status' => 'AVAILABLE',
            'expires_at' => '2027-12-31'
        ];

        $request = collect($request);

        Product::create([
            'supplier_id' => $request->supplier_id,
            'name' => $request->name,
            'price' => $request->price,
            'type' => $request->type,
            'status' => $request->status,
            'expires_at' => $request->expires_at
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $request = [
            'supplier_id' => 7,
            'name' => 'Luva Cirúrgica Estéril Atualizada',
            'price' => 'R$95.50',
            'type' => 'EQUIPAMENTO',
            'status' => 'FORA DE ESTOQUE',
            'expires_at' => '2028-06-30'
        ];

        $request = collect($request);

        $product->update([
            'supplier_id' => $request->supplier_id,
            'name' => $request->name,
            'price' => $request->price,
            'type' => $request->type,
            'status' => $request->status,
            'expires_at' => $request->expires_at
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
    }
}
