<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransferRequest;
use App\Models\Product;
use App\Models\Transfer;
use App\Models\Warehouse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        // GET All transfers from user
        $transfers = Auth::user()->transfers;
        return view('transfers',
        [
            // Send list of products to products view
            'transfers' => $transfers
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        // Fetch all the warehouses from login user
        $warehouses = Auth::user()->warehouses;

        // Get all the products from login user
        $products = Auth::user()->products;

        if ($products->count() && $warehouses->count()) {
            return view('shared.transfers-edit-form',
            [
                // Send list of warehouses to tranfers-edit-form view
                'warehouses' => $warehouses,
                'products' => $products,
            ]);
        } else {
            return redirect()->route('dashboard')->with('warning-message', 'Asegurate de tener productos y almacenes registrados');
        }

        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TransferRequest $request)
    {
        //
        $product_transferInfo = $request->safe()->only('product', 'quantity');
        $transfer_details = $request->safe()->except('product', 'quantity');
        $product_id = $product_transferInfo['product'];
        $product_quantity = $product_transferInfo['quantity'];

        $product_transfer = array_combine($product_id, $product_quantity);


        $sourceWarehouse = $transfer_details['source_warehouse_id'];
        $destinationWarehouse = $transfer_details['destination_warehouse_id'];

        if ($sourceWarehouse === $destinationWarehouse) {
            return redirect()->back()->with('warning-message', 'Los almacenes no pueden ser iguales');
        }

        $warehouse = Warehouse::findOrFail($sourceWarehouse);

        $dataToAttach = array();

        foreach ($product_transfer as $key => $value) {
            $dataToAttach[$key] = [ 
                'quantity'=>$value,
            ];

            $productsss = Product::findOrFail($key);

            if ($value > $productsss->getTransferData($key, $sourceWarehouse)) {
                return redirect()->back()->with('warning-message', 'No hay suficiente stock para realizar la operación');
            }
        }





        $transfer = new Transfer();
        $transfer->source_warehouse_id = $sourceWarehouse;
        $transfer->destination_warehouse_id = $destinationWarehouse;
        $transfer->sentDate = Carbon::now();
        $transfer->receivedDate = null;
        $transfer->user_id = Auth::user()->id;

        $transfer->save();

        $transfer->products()->attach($dataToAttach);

        return redirect()->route('transfers.index')->with('success-message', 'Transferencia creada con exito');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transfer $transfer)
    {
        //

        if ($transfer->user_id !== Auth::user()->id) {
            abort(403, 'Unauthorized');
        }

        return view('transfers-show',
        [
            // Send $transfer item
            'transfer' => $transfer,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transfer $transfer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transfer $transfer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transfer $transfer)
    {
        if ($transfer->user_id !== Auth::user()->id) {
            abort(403, 'Unauthorized');
        }
        
        // Delete product data
        $transfer->delete();

        // Redirect
        return redirect()->route('transfers.index')->with('success-message', 'Transferencia eliminada con exito');
    }


    /**
     * Confirm the transfer to send.
     */
    public function confirmTransfer(Transfer $transfer)
    {
        // La funcion confirma que el stock este existente y lo resta. De igual manera añade el stock al almacen de destino


        if ($transfer->user_id !== Auth::user()->id) {
            abort(403, 'Unauthorized');
        }

        // initialize array
        $dataToAttach = array();

        foreach ($transfer->products as $product) {;

            // Obtener la resta del almacen de origen y la cantidad a enviar
            $subtractQuantity = $product->getTransferData($product->id, $transfer->source_warehouse_id) - $product->pivot->quantity;

            // Obtener la suma del almacen de destino y la cantidad a enviar
            $addQuantity = $product->getTransferData($product->id, $transfer->destination_warehouse_id) + $product->pivot->quantity;

            // Crear array
            $dataToAttachSubtract[$product->id] = [
                'quantityAvailable' => $subtractQuantity
            ];

            $dataToAttachAdd[$product->id] = [
                'quantityAvailable' => $addQuantity
            ];

            
        }



        // Actualizar almacen de origen con la cantidad a restar
        $sourceWarehouse = Warehouse::findOrFail($transfer->source_warehouse_id);
        $sourceWarehouse->products()->sync($dataToAttachSubtract);

        // Actualizar almacen de destino con la cantidad a añadir
        $destinationWarehouse = Warehouse::findOrFail($transfer->destination_warehouse_id);
        $destinationWarehouse->products()->sync($dataToAttachAdd);

        $transfer->status = 'enviado';
        $transfer -> save();

        // Redirect
        return redirect()->route('transfers.index')->with('success-message', 'Transferencia enviada con exito');
    }
}
