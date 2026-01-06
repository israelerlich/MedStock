<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = Supplier::latest()->get();
        return view('suppliers.index', compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('suppliers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSupplierRequest $request)
    {
        $supplier = Supplier::create($request->validated());
        
        // Criar endereço se fornecido
        if ($request->filled('cep')) {
            $supplier->address()->create([
                'cep' => $request->cep,
                'city' => $request->city,
                'state' => $request->state,
                'district' => $request->district,
                'country' => $request->country ?? 'br',
                'street' => $request->street,
                'complement_number' => $request->complement_number ?: '',
                'address_number' => $request->address_number,
            ]);
        }
        
        return redirect()->route('suppliers.index')->with('success', 'Fornecedor cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        $supplier->load('address');
        return view('suppliers.show', compact('supplier'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        $supplier->load('address');
        return view('suppliers.edit', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSupplierRequest $request, Supplier $supplier)
    {
        $supplier->update($request->validated());
        
        // Atualizar ou criar endereço
        if ($request->filled('cep')) {
            $supplier->address()->updateOrCreate(
                ['referring_type' => Supplier::class, 'referring_id' => $supplier->id],
                [
                    'cep' => $request->cep,
                    'city' => $request->city,
                    'state' => $request->state,
                    'district' => $request->district,
                    'country' => $request->country ?? 'br',
                    'street' => $request->street,
                    'complement_number' => $request->complement_number ?: '',
                    'address_number' => $request->address_number,
                ]
            );
        }
        
        return redirect()->route('suppliers.index')->with('success', 'Fornecedor atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return redirect()->route('suppliers.index')->with('success', 'Fornecedor excluído com sucesso!');
    }
}
