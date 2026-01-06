<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('supplier')->latest()->get();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $suppliers = \App\Models\Supplier::all();
        $hospitals = \App\Models\Hospital::all();
        return view('products.create', compact('suppliers', 'hospitals'));
    }

    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();
        
        if (empty($data['expires_at'])) {
            $data['expires_at'] = null;
        }
        
        Product::create($data);
        return redirect()->route('products.index')->with('success', 'Produto cadastrado com sucesso!');
    }

    public function show(Product $product)
    {
        $product->load('supplier', 'hospital');
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $suppliers = \App\Models\Supplier::all();
        $hospitals = \App\Models\Hospital::all();
        return view('products.edit', compact('product', 'suppliers', 'hospitals'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->validated();
        
        if (empty($data['expires_at'])) {
            $data['expires_at'] = null;
        }
        
        $product->update($data);
        return redirect()->route('products.index')->with('success', 'Produto atualizado com sucesso!');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produto excluído com sucesso!');
    }
}
