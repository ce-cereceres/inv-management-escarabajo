<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        // Get all the warehouses from login user
        $warehouses = Auth::user()->warehouses;

        return view('warehouses',
        [
            // Send list of products to products view
            'warehouses' => $warehouses,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

        //Return the Form view
        return view('shared.warehouse-edit-form',
            [

            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // data retrived from warehouse-edit-form.blade.php


        $validated = $request->validate([
            'name' => 'required|string',
            'street' => 'required|string',
            'streetNumber' => 'required|numeric|min:1|max:32766',
            'zipCode' => 'required|string',
        ]);

        Warehouse::create($validated + ['user_id' => Auth::user()->id]);

        return redirect()->route('warehouses.index')->with('success-message', 'Almacén creado con exito');
    }

    /**
     * Display the specified resource.
     */
    public function show(Warehouse $warehouse)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Warehouse $warehouse)
    {
        //
        if ($warehouse->user_id !== Auth::user()->id) {
            abort(403, 'Unauthorized');
        }

        $editing = true;

        
        return view('warehouse-details',
            [
                'warehouse'=>$warehouse,
                'editing'=>$editing,
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Warehouse $warehouse)
    {
        //

        if ($warehouse->user_id !== Auth::user()->id) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'name' => 'required|string',
            'street' => 'required|string',
            'streetNumber' => 'required|numeric|min:1|max:32766',
            'zipCode' => 'required|string',
        ]);


        $warehouse->name = $validated['name'];
        $warehouse->street = $validated['street'];
        $warehouse->streetNumber = $validated['streetNumber'];
        $warehouse->zipCode = $validated['zipCode'];

        $warehouse->save();

        return redirect()->route('warehouses.index')->with('success-message', 'Almacen actualizado con exito');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Warehouse $warehouse)
    {
        if ($warehouse->user_id !== Auth::user()->id) {
            abort(403, 'Unauthorized');
        }
        
        // Delete product data
        $warehouse->delete();

        // Redirect
        return redirect()->route('warehouses.index')->with('success-message', 'Almacen eliminado con exito');
    }
}
