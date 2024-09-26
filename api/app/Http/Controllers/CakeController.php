<?php

namespace App\Http\Controllers;

use App\Models\Cake;
use Illuminate\Http\Request;

class CakeController extends Controller
{
    public function index()
    {
        return Cake::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'flavor' => 'required',
            'size' => 'required',
            'price' => 'required|numeric'
        ]);

        return Cake::create($request->all());
    }

    public function show($id)
    {
        return Cake::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $cake = Cake::findOrFail($id);
        $cake->update($request->all());

        return $cake;
    }

    public function destroy($id)
    {
        Cake::findOrFail($id)->delete();
        return response()->noContent();
    }
}

