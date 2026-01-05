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
        $supplier = Supplier::get()->take(5);
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
    public function store(StoreSupplierRequest $request)
    {
        $request = [
    'company_name' => "Cirúrgica e Hospitalar São Paulo LTDA",
    'commercial_name' => "Cirúrgica SP",
    'phone_number' => "(21) 2987-6543",
    'cnpj' => "98.765.432/0001-10",
    'email' => "vendas@cirurgicasp.com.br"
        ];
        

        $request = collect($request);

       Supplier::create([
        'company_name' => $request->company_name,
        'commercial_name' => $request->commercial_name,
        'phone_number' => $request->phone_number,
        'cnpj' => $request->cnpj,
        'email' => $request->email
    ]);
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSupplierRequest $request, Supplier $supplier)
    {
        $request = [
            'company_name' => "Tecnologia e Diagnóstico Vital LTDA",
            'commercial_name' => "Vital Tech",
            'phone_number' => "(31) 3221-9876",
            'cnpj' => "45.678.901/0001-22",
            'email' => "suporte@vitaltech.med.br"
        ];

        $request = collect($request);

        $supplier->update([
            'company_name' => $request->company_name,
            'commercial_name' => $request->commercial_name,
            'phone_number' => $request->phone_number,
            'cnpj' => $request->cnpj,
            'email' => $request->email
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
    }
}
