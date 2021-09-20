<?php

namespace App\Http\Controllers\Commerce;

use App\Http\Controllers\Controller;
use App\Models\Commerce\Product;
use App\Models\Commerce\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allProducts = Product::all();
        return response()->json($allProducts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string'],
            'price' => ['required', 'numeric'],
            'type' => ['required', 'integer'],
            'thumb' => ['required', 'file', 'mimes:png,jpg,gif'],
            'qtd' => ['required', 'integer'],
        ]);

        $storegeFile = $request->file('thumb')->store('public/contents');
        $filePath = str_replace('public', 'storage', $storegeFile);

        $data = $request->only(['name', 'price', 'qtd', 'type']);
        $data['thumb'] = $filePath;

        $findType = ProductType::find($data['type']);
        $data['type_id'] = $findType->id;

        $createdProduct = Product::create($data);

        return response()->json($createdProduct, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->only(['name', 'price', 'qtd', 'type']);
        $getProduct = Product::where('id', $id);
        $getProduct->update($data);

        return response()->json($getProduct->first());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->destroy($product->id);
        return response()->json([], 204);
    }
}
