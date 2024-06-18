<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Milon\Barcode\DNS1D;
use Barryvdh\DomPDF\Facade\Pdf;

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

        // Get all the warehouses from login user
        $warehouses = Auth::user()->warehouses;

        if ($warehouses->count()) {
            return view('products',
                [
                    // Send list of products to products view
                    'products' => $products,
                ]);
        } else {
            return redirect()->route('warehouses.index')->with('warning-message', 'Crea tu primer almacen para empezar');
        }

        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

        //Fetch all the categories
        $categories = Category::all();

        // Fetch all the warehouses from login user
        $warehouses = Auth::user()->warehouses;

        //Return the Form view
        return view('shared.product-edit-form',
            [
                /* Send lists from categories and warehouses */
                'categories' => $categories,
                'warehouses' => $warehouses,
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        // data retrived from product-edit-form.blade.php


        // Information about product details
        $productInfo = $request->safe()->except(['warehouses']);

        // Information about warehouse store details
        $warehousesArray = $request->safe()->only(['warehouses']);

        
        // Obtain array from warehouse
        $warehousesData = $warehousesArray['warehouses'];

        // initialize array
        $dataToAttach = array();

        // Assign data to array
        foreach ($warehousesData as $warehouseInfo) {

            $dataToAttach[$warehouseInfo['id']] = [ 
                    'quantityAvailable'=>$warehouseInfo['quantityAvailable'],
                    'minimumStockLevel'=>0,
                    'maximumStockLevel'=>0,
                    'reoredPoint'=>0,
                
            ];
        }

        /* dump($dataToAttach); */
        
        // Create new product
        $product = new Product();
        $product->name = $productInfo['name'];
        $product->price = $productInfo['price'];
        $product->sku = $productInfo['sku'];
        $product->description = $productInfo['description'];
        $product->category_id = $productInfo['category_id'];
        $product->user_id = Auth::user()->id;
        $product->barcode = $productInfo['barcode'];
        $product->save(); 

        // Create pivot table product_warehouse
        $product->warehouses()->attach($dataToAttach);

        // redirect
        return redirect()->route('products.index')->with('success-message', 'Producto creado con exito');

        
    }


    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
        if ($product->user_id !== Auth::user()->id) {
            abort(403, 'Unauthorized');
        }

        return view('products-details',
            [
                'product'=>$product,
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
        if ($product->user_id !== Auth::user()->id) {
            abort(403, 'Unauthorized');
        }

        $editing = true;
        $categories = Category::all();

        // Fetch all the warehouses from login user
        $warehouses = Auth::user()->warehouses;
        
        return view('products-details',
            [
                'product'=>$product,
                'editing'=>$editing,
                'categories' => $categories,
                'warehouses' => $warehouses,
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        if ($product->user_id !== Auth::user()->id) {
            abort(403, 'Unauthorized');
        }
        // Product Details
        $productInfo = $request->safe()->except(['warehouses']);

        // Warehouse inventory details
        $warehousesArray = $request->safe()->only(['warehouses']);

        
        // Obtain array from warehouse
        $warehousesData = $warehousesArray['warehouses'];

        // initialize array
        $dataToAttach = array();

        // Assign data to array
        foreach ($warehousesData as $warehouseInfo) {

            $dataToAttach[$warehouseInfo['id']] = [ 
                    'quantityAvailable'=>$warehouseInfo['quantityAvailable'],
                    'minimumStockLevel'=>0,
                    'maximumStockLevel'=>0,
                    'reoredPoint'=>0,
                
            ];
        }


        $product->name = $productInfo['name'];
        $product->price = $productInfo['price'];
        $product->sku = $productInfo['sku'];
        $product->description = $productInfo['description'];
        $product->category_id = $productInfo['category_id'];
        $product->barcode = $productInfo['barcode'];

        $product->save();

        $product->warehouses()->sync($dataToAttach);

        return redirect()->route('products.index')->with('success-message', 'Producto actualizado con exito');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
        if ($product->user_id !== Auth::user()->id) {
            abort(403, 'Unauthorized');
        }

        // Delete warehouses inventory data
        $product->warehouses()->detach();

        // Delete product data
        $product->delete();

        // Redirect
        return redirect()->route('products.index')->with('success-message', 'Producto eliminado con exito');
    }

    public function barcode(Product $product)
    {
        if ($product->user_id !== Auth::user()->id) {
            abort(403, 'Unauthorized');
        }
        /* return view('barcode')->with('product', $product); */
        $pdf = Pdf::loadView('barcode', compact('product'))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }
}
