<?php

namespace App\Http\Controllers;

use App\Models\Cake;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CakeController extends Controller
{
    public function index()
    {
        $cakes = Cake::all();
        $data['success'] = true;
        $data['result'] = $cakes;
        return response()->json($data, Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
            'flavor' => 'required',
            'size' => 'required',
            'price' => 'required|numeric'
        ]);

        $cake = Cake::create($validate);
        if ($cake) {
            $response['success'] = true;
            $response['message'] = 'Cake berhasil ditambahkan.';
            return response()->json($response, Response::HTTP_CREATED);
        }
    }

    public function show($id)
    {
        $cake = Cake::find($id);
        if ($cake) {
            $response['success'] = true;
            $response['result'] = $cake;
            return response()->json($response, Response::HTTP_OK);
        } else {
            $response['success'] = false;
            $response['message'] = 'Cake tidak ditemukan.';
            return response()->json($response, Response::HTTP_NOT_FOUND);
        }
    }

    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'name' => 'required|string',
            'flavor' => 'required|string',
            'size' => 'required|string',
            'price' => 'required|numeric'
        ]);

        $cake = Cake::where('id', $id)->update($validate);
        if ($cake) {
            $response['success'] = true;
            $response['message'] = 'Cake berhasil diperbarui.';
            return response()->json($response, Response::HTTP_OK);
        } else {
            $response['success'] = false;
            $response['message'] = 'Cake tidak ditemukan.';
            return response()->json($response, Response::HTTP_NOT_FOUND);
        }
    }

    public function destroy($id)
    {
        $cake = Cake::where('id', $id);
        if ($cake->exists()) {
            $cake->delete();
            $response['success'] = true;
            $response['message'] = 'Cake berhasil dihapus.';
            return response()->json($response, Response::HTTP_OK);
        } else {
            $response['success'] = false;
            $response['message'] = 'Cake tidak ditemukan.';
            return response()->json($response, Response::HTTP_NOT_FOUND);
        }
    }
}

