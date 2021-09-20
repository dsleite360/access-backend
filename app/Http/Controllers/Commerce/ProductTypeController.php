<?php

namespace App\Http\Controllers\Commerce;

use App\Http\Controllers\Controller;
use App\Models\Commerce\ProductType;
use Illuminate\Http\Request;

class ProductTypeController extends Controller
{
    public function index()
    {
        $allProductsTypes = ProductType::all();
        return response()->json($allProductsTypes);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'min:4', 'unique:product_types'],
            'display_name' => ['required', 'string', 'min:4'],
            'description' => ['nullable', 'string', 'min:4'],
        ]);

        $data = $request->only(['name', 'description', 'display_name']);

        $createdType = ProductType::create($data);

        return response()->json($createdType, 201);
    }

    public function show($id)
    {
        $existsType = ProductType::find($id);

        if (!$existsType) {
            return response()->json(['message' => 'Tipo de produto não encontrado'], 400);
        }

        return response()->json($existsType);
    }

    public function update(Request $request, $id)
    {
        $getType = ProductType::where('id', $id);

        if (!$getType) {
            return response()->json(['message' => 'Tipo de produto não encontrado'], 400);
        }

        $data = $request->only(['name', 'description', 'display_name']);

        $getType->update($data);
        $updatedType = $getType->input('name');

        return response()->json($updatedType);
    }

    public function destroy($id)
    {
        ProductType::destroy($id);
        return response()->json([], 204);
    }
}
