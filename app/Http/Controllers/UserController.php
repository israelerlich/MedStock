<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::latest()->get();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $hospitals = \App\Models\Hospital::all();
        return view('users.create', compact('hospitals'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);
        
        // Vincular hospitais ao usuário
        if ($request->has('hospitals')) {
            foreach ($request->hospitals as $hospitalId) {
                \App\Models\UserHospital::create([
                    'user_id' => $user->id,
                    'hospital_id' => $hospitalId
                ]);
            }
        }
        
        return redirect()->route('users.index')->with('success', 'Usuário cadastrado com sucesso!');
    }
         
    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $userHospitals = \App\Models\UserHospital::where('user_id', $user->id)
            ->with('hospital')
            ->get();
        return view('users.show', compact('user', 'userHospitals'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $hospitals = \App\Models\Hospital::all();
        $userHospitals = \App\Models\UserHospital::where('user_id', $user->id)
            ->pluck('hospital_id')
            ->toArray();
        return view('users.edit', compact('user', 'hospitals', 'userHospitals'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }
        $user->update($data);
        
        // Atualizar hospitais vinculados
        \App\Models\UserHospital::where('user_id', $user->id)->delete();
        if ($request->has('hospitals')) {
            foreach ($request->hospitals as $hospitalId) {
                \App\Models\UserHospital::create([
                    'user_id' => $user->id,
                    'hospital_id' => $hospitalId
                ]);
            }
        }
        
        return redirect()->route('users.index')->with('success', 'Usuário atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Usuário excluído com sucesso!');
    }
}
