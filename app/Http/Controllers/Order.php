<?php

namespace App\Http\Controllers;

use App\Models\Order as ModelsOrder;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class Order extends Controller
{
    public $json = [];
    public $status = 200;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $productId = request('product_id');
        $quantity = request('quantity');

        $token = $request->bearerToken();
        $authorization = User::where('remember_token', $token)->first();
        $product = Product::find($productId);
        $availableStock = $product['available_stock'];
        $stockChanges = $availableStock - $quantity;
        

        if ($availableStock < $quantity) {
            return response()->json(['message' => 'Failed to order this product due to unavailability of the stock'], 400); 
        }

        if (!$authorization) { // additional validation for acess_token
            return response()->json(['message' => 'Invalid authorization'], 401);
        }

        $store = ModelsOrder::create([
            'product_id' => $productId,
            'quantity' => $quantity
        ]);

        if ($store) {
            $product->available_stock = (int) $stockChanges;
            $product->save();
            $this->json = ['message' => 'You have successfully ordered this product.'];
            $this->status = 201;
        } else {
            $this->json = ['message' => 'Failed to order this product'];
            $this->status = 400;
        }

        return response()->json($this->json, $this->status);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
