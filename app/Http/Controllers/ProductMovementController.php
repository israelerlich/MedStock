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
    public function store(StoreProductMovementRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductMovement $productMovement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductMovement $productMovement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductMovementRequest $request, ProductMovement $productMovement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductMovement $productMovement)
    {
        //
    }
}
