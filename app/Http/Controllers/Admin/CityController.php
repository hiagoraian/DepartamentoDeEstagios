<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::orderBy('name')->get();

        return view('admin.cities.index', compact('cities'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $data['name'] = trim($data['name']);

        City::updateOrCreate(
            ['name' => $data['name'], 'uf' => 'MG'],
            ['ibge_code' => null]
        );

        return redirect()->route('admin.cities.index')->with('success', 'Cidade cadastrada/atualizada com sucesso!');
    }


    public function edit(City $city)
    {
        return view('admin.cities.edit', compact('city'));
    }

    public function update(Request $request, City $city)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $city->update([
            'name' => $data['name'],
        ]);

        return redirect()->route('admin.cities.index')->with('success', 'Cidade atualizada com sucesso!');
    }

    public function destroy(City $city)
    {
        $city->delete();

        return redirect()->route('admin.cities.index')->with('success', 'Cidade removida com sucesso!');
    }
}
