<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;/*  */

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        // Get all the products from login user
        $products = Auth::user()->products;

        return view('products',
        [
            // Send list of products to products view
            'products' => $products,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $categories = Category::all();
        return view('shared.product-edit-form',
            [
                'categories' => $categories,
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // data retrived from product-edit-form.blade.php


        $validated = $request->validate([
            'name' => 'required',
            'price' => 'required',
            'sku' => 'required',
            'description' => 'required',
            'category_id' => 'required',
        ]);

        Product::create($validated + ['user_id' => Auth::user()->id]);

        return redirect()->route('products.index')->with('success-message', 'Producto creado con exito');
        
        /* 
        Old functional method
        
        request()->validate(
            [
            'name' => 'required',
            'price' => 'required',
            'sku' => 'required',
            'description' => 'required',
            'category_id' => 'required',
            ]
        ); 

        Product::create(
            [
                'name' => request()->get('name', ''),
                'price' => request()->get('price', ''),
                'sku' => request()->get('sku', ''),
                'description' => request()->get('description', ''),
                'user_id' => Auth::user()->id,
                'category_id' => request()->get('category_id', ''),
            ]
        ); */

        
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
