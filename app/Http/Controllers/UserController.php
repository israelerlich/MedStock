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
    public function index()
    {
        $users = User::latest()->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $hospitals = \App\Models\Hospital::all();
        return view('users.create', compact('hospitals'));
    }

    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);
        
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
         
    public function show(User $user)
    {
        $userHospitals = \App\Models\UserHospital::where('user_id', $user->id)
            ->with('hospital')
            ->get();
        return view('users.show', compact('user', 'userHospitals'));
    }

    public function edit(User $user)
    {
        $hospitals = \App\Models\Hospital::all();
        $userHospitals = \App\Models\UserHospital::where('user_id', $user->id)
            ->pluck('hospital_id')
            ->toArray();
        return view('users.edit', compact('user', 'hospitals', 'userHospitals'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }
        $user->update($data);
        
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

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Usuário excluído com sucesso!');
    }
}
