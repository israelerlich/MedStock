<?php

namespace App\Http\Controllers;

use App\Models\ProductMovement;
use App\Http\Requests\StoreProductMovementRequest;
use App\Http\Requests\UpdateProductMovementRequest;

class ProductMovementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productMovements = ProductMovement::with(['product', 'client'])->latest()->get();
        return view('product-movements.index', compact('productMovements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = \App\Models\Product::with('supplier')->get();
        $clients = \App\Models\Client::all();
        return view('product-movements.create', compact('products', 'clients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductMovementRequest $request)
    {
        $data = $request->validated();
        
        // Calcula o preço total automaticamente
        $product = \App\Models\Product::findOrFail($data['product_id']);
        $data['unit_price'] = $product->price;
        $data['total_price'] = $product->price * $data['quantity'];
        
        ProductMovement::create($data);
        
        return redirect()->route('product-movements.index')->with('success', 'Movimentação cadastrada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductMovement $productMovement)
    {
        $productMovement->load(['product', 'client']);
        return view('product-movements.show', compact('productMovement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductMovement $productMovement)
    {
        $products = \App\Models\Product::with('supplier')->get();
        $clients = \App\Models\Client::all();
        return view('product-movements.edit', compact('productMovement', 'products', 'clients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductMovementRequest $request, ProductMovement $productMovement)
    {
        $data = $request->validated();
        
        // Recalcula o preço total se a quantidade mudou
        if (isset($data['quantity'])) {
            $product = $productMovement->product;
            $data['unit_price'] = $product->price;
            $data['total_price'] = $product->price * $data['quantity'];
        }
        
        $productMovement->update($data);
        
        return redirect()->route('product-movements.index')->with('success', 'Movimentação atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductMovement $productMovement)
    {
        $productMovement->delete();
        return redirect()->route('product-movements.index')->with('success', 'Movimentação excluída com sucesso!');
    }
}
