<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Models\Client;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Models\Address;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $address = Address::get()->take(5);

        dd($address);
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
    public function store(StoreClientRequest $request)
    {
        $request = [
            'user_id' => 1,
            'name' => "Dr. Carlos Silva",
            'cpf' => "123.456.789-00",
            'phone_number' => "(11) 98765-4321"
            //PROFISSAO
        ];

        $request = collect($request);

        Client::create([
            'user_id' => $request->user_id,
            'name' => $request->name,
            'cpf' => $request->cpf,
            'phone_number' => $request->phone_number
            //PROFISSAO
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        $request = [
            
        ]
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClientRequest $request, Client $client)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        //ID
    }
}
