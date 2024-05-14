<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Stock;
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
    public function store(Request $request)
    {
        // data retrived from product-edit-form.blade.php

        // Fetch all the warehouses from login user
        $warehouses = Auth::user()->warehouses;

        // Form rules
        $rules = [
            'name' => 'required',
            'price' => 'required',
            'sku' => 'required',
            'description' => 'required',
            'category_id' => 'required',
        ];

        // Wrehouses
        $listWarehouses = [];

        // Dynamic rules from warehouses
        foreach ($warehouses as $warehouse) {

            $rules['warehouse_' . $warehouse->id] = 'required';
            $listWarehouses['warehouse_' . $warehouse->id];
        }

        // Validate
        $validated = $request->validate($rules);


        /* Working rules method

        $validated = $request->validate([
            'name' => 'required',
            'price' => 'required',
            'sku' => 'required',
            'description' => 'required',
            'category_id' => 'required',
        ]); */

        /* Working Create method
        
        Product::create([
            'name' => $validated['name'],
            'price' => $validated['price'],
            'sku' => $validated['sku'],
            'description' => $validated['description'],
            'category_id' => $validated['category_id'],
            'user_id' => Auth::user()->id,
        ]); */

        $newProduct = $this->saveProduct($validated);

        $this->saveStock($listWarehouses, $newProduct);


        return redirect()->route('products.index')->with('success-message', 'Producto creado con exito');

        
    }

    private function saveProduct($validated)
    {
        $product = new Product;
        $product->name = $validated['name'];
        $product->price = $validated['price'];
        $product->sku = $validated['sku'];
        $product->description = $validated['description'];
        $product->category_id = $validated['category_id'];
        $product->user_id = Auth::user()->id;

        $product->save();

        return $product->id;


    }

    private function saveStock($listWarehouses, $newProduct_id)
    {
        foreach ($listWarehouses as $warehouse) {
            $stock = new Stock;
            $stock->product_id = $newProduct_id;
            $stock->warehouse_id;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //

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
        $editing = true;
        $categories = Category::all();
        
        return view('products-details',
            [
                'product'=>$product,
                'editing'=>$editing,
                'categories' => $categories,

            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //

        $validated = $request->validate([
            'name' => 'required',
            'price' => 'required',
            'sku' => 'required',
            'description' => 'required',
            'category_id' => 'required',
        ]);


        $product->name = $validated["name"];
        $product->price = $validated["price"];
        $product->sku = $validated["sku"];
        $product->description = $validated["description"];
        $product->category_id = $validated["category_id"];

        $product->save();

        return redirect()->route('products.index')->with('success-message', 'Producto actualizado con exito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //

        $product->delete();

        return redirect()->route('products.index')->with('success-message', 'Producto eliminado con exito');
    }
}
