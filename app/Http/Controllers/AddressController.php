<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;
use Symfony\Component\Mime\Address as MimeAddress;

class AddressController extends Controller
{
    public function index()
    {
        $addresses = Address::latest()->get();
        return view('addresses.index', compact('addresses'));
    }

    public function create()
    {
        return view('addresses.create');
    }

    public function store(StoreAddressRequest $request)
    {
        Address::create($request->validated());
        return redirect()->route('addresses.index')->with('success', 'Endereço cadastrado com sucesso!');
    }

    public function show(Address $address)
    {
        return view('addresses.show', compact('address'));
    }

    public function edit(Address $address)
    {
        return view('addresses.edit', compact('address'));
    }

    public function update(UpdateAddressRequest $request, Address $address)
    {
        $address->update($request->validated());
        return redirect()->route('addresses.index')->with('success', 'Endereço atualizado com sucesso!');
    }

    public function destroy(Address $address)
    {
        $address->delete();
        return redirect()->route('addresses.index')->with('success', 'Endereço excluído com sucesso!');
    }
}