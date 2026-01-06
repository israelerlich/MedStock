<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Models\Client;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Models\Address;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::with('user')->latest()->get();
        return view('clients.index', compact('clients'));
    }

    public function create()
    {
        $users = \App\Models\User::all();
        return view('clients.create', compact('users'));
    }

    public function store(StoreClientRequest $request)
    {
        $client = Client::create($request->validated());
        
        if ($request->filled('cep')) {
            $client->address()->create([
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
        
        return redirect()->route('clients.index')->with('success', 'Cliente cadastrado com sucesso!');
    }

    public function show(Client $client)
    {
        $client->load('user', 'address');
        return view('clients.show', compact('client'));
    }

    public function edit(Client $client)
    {
        $client->load('address');
        $users = \App\Models\User::all();
        return view('clients.edit', compact('client', 'users'));
    }

    public function update(UpdateClientRequest $request, Client $client)
    {
        $client->update($request->validated());
        
        if ($request->filled('cep')) {
            $client->address()->updateOrCreate(
                ['referring_type' => Client::class, 'referring_id' => $client->id],
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
        
        return redirect()->route('clients.index')->with('success', 'Cliente atualizado com sucesso!');
    }

    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->route('clients.index')->with('success', 'Cliente excluído com sucesso!');
    }
}
