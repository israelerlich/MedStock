<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;
use Symfony\Component\Mime\Address as MimeAddress;

class AddressController extends Controller
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
    public function store(StoreAddressRequest $request)
    {
        $request = [
            'referring_type' => 'App\Models\Client',
            'referring_id' => 1,
            'cep' => '01310-100',
            'city' => 'São Paulo',
            'state' => 'SP',
            'district' => 'Centro',
            'country' => 'BRAZIL',
            'street' => 'Avenida Paulista',
            'complement_number' => 'Apartamento 501',
            'address_number' => '1000'
        ];

        $request = collect($request);

        Address::create([
            'referring_type' => $request->referring_type,
            'referring_id' => $request->referring_id,
            'cep' => $request->cep,
            'city' => $request->city,
            'state' => $request->state,
            'district' => $request->district,
            'country' => $request->country,
            'street' => $request->street,
            'complement_number' => $request->complement_number,
            'address_number' => $request->address_number
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Address $address)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Address $address)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAddressRequest $request, Address $address)
    {
        $request = [
            'referring_type' => 'App\Models\Hospital',
            'referring_id' => 2,
            'cep' => '04567-890',
            'city' => 'Rio de Janeiro',
            'state' => 'RJ',
            'district' => 'Copacabana',
            'country' => 'BRAZIL',
            'street' => 'Rua Barata Ribeiro',
            'complement_number' => 'Sala 302',
            'address_number' => '500'
        ];

        $request = collect($request);

        $address->update([
            'referring_type' => $request->referring_type,
            'referring_id' => $request->referring_id,
            'cep' => $request->cep,
            'city' => $request->city,
            'state' => $request->state,
            'district' => $request->district,
            'country' => $request->country,
            'street' => $request->street,
            'complement_number' => $request->complement_number,
            'address_number' => $request->address_number
        ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Address $address)
    {
        $address->delete();
    }
}