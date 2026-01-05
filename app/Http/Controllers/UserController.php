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
        $user = User::get()->take(5);

        dd($user);
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
    public function store(StoreUserRequest $request)
    {
        $request = [
            'name' => "Israel",
            'email' => "israel@gmail.com",
            'password' => 'senhaForte'
        ];

        $request = collect($request);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => Role::USER
        ]);
    }
         
    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request)
    {
        $user = Auth::user();

        $request = [
            'name' => "Israel Editado",
            'email' => "israel_editado@gmail.com",
        ];

        $request = collect($request);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($user_id)
    {
        $user = User::find($user_id);
        $user->delete;
    }
}
