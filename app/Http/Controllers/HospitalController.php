<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use App\Http\Requests\StoreHospitalRequest;
use App\Http\Requests\UpdateHospitalRequest;
use Illuminate\Support\Facades\Auth;

class HospitalController extends Controller
{
    public function index()
    {
        $hospitals = Hospital::get();
        return view('hospitals.index', compact('hospitals'));
    }

    public function create()
    {
        return view('hospitals.create');
    }

    public function store(StoreHospitalRequest $request)
    {
        Hospital::create($request->validated());
        return redirect()->route('hospitals.index')->with('success', 'Hospital cadastrado com sucesso!');
    }

    public function show(Hospital $hospital)
    {
        return view('hospitals.show', compact('hospital'));
    }

    public function edit(Hospital $hospital)
    {
        return view('hospitals.edit', compact('hospital'));
    }

    public function update(UpdateHospitalRequest $request, Hospital $hospital)
    {
        $hospital->update($request->validated());
        return redirect()->route('hospitals.index')->with('success', 'Hospital atualizado com sucesso!');
    }

    public function destroy(Hospital $hospital)
    {
        $hospital->delete();
        return redirect()->route('hospitals.index')->with('success', 'Hospital excluído com sucesso!');
    }
}
