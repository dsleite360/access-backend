<?php

namespace App\Http\Controllers\Commerce;

use App\Http\Controllers\Controller;
use App\Models\Commerce\Product;
use App\Models\Commerce\ProdutoPurchase;
use App\Models\Commerce\Purchase;
use Illuminate\Http\Request;

class PurchasesController extends Controller
{
    public function index()
    {
        $all = Purchase::where('user_id', auth()->user()->id)->get();

        $remapPurchase = collect($all)->map(function ($item, $index) {
            return [
                'total' => floatval($item->total),
                'items' => $item->items,
                'created_at' => $item->created_at,
            ];
        });

        return response()->json($remapPurchase);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'products' => ['required', 'array'],
        ]);

        $products = $request->only(['products'])['products'];
        $purchaseItems = [];

        foreach($products as $product) {
            $exitstProduct = Product::find($product);

            if (!$exitstProduct) {
                return response()->json(['message' => "O produto '{$product}' não foi encontrado"], 400);
            }

            array_push($purchaseItems, [
                'product_id' => $exitstProduct->id,
                'price' => floatval($exitstProduct->price),
            ]);
        }

        $createdPurchase = Purchase::create([
            'user_id' => auth()->user()->id,
            'total' => 0,
            'status_id' => 2,
        ]);

        foreach($purchaseItems as $purchaseItem) {
            ProdutoPurchase::create([
                'purchase_id' => $createdPurchase->id,
                'product_id' => $purchaseItem['product_id'],
            ]);

            $createdPurchase->total += $purchaseItem['price'];
        }

        $createdPurchase->save();

        return response()->json($createdPurchase, 201);
    }
}
