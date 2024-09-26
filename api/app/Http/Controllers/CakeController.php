<?php

namespace App\Http\Controllers;

use App\Models\Cake;
use Illuminate\Http\Request;

class CakeController extends Controller
{
    // Menampilkan daftar kue
    public function index()
    {
        $cakes = Cake::all();
        return response()->json($cakes);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'flavor' => 'required',
            'size' => 'required',
            'price' => 'required|numeric',
        ]);

        $cake = Cake::create($request->all());
        return response()->json($cake);
    }

    // untuk menampilkan kue berdasarkan id
    public function show($id)
    {
        $cake = Cake::findOrFail($id);
        return response()->json($cake);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'flavor' => 'required',
            'size' => 'required',
            'price' => 'required|numeric',
        ]);

        $cake = Cake::findOrFail($id);
        $cake->update($request->all());
        return response()->json($cake);
    }

    public function destroy($id)
    {
        $cake = Cake::findOrFail($id);
        $cake->delete();
        return response()->json(['message' => 'Cake deleted successfully']);
    }
}
