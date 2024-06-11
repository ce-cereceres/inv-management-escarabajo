<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransferRequest;
use App\Models\Transfer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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


        return view('shared.transfers-edit-form',
        [
            // Send list of warehouses to tranfers-edit-form view
            'warehouses' => $warehouses,
            'products' => $products,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TransferRequest $request)
    {
        //
        $product_transferInfo = $request->safe()->only('product', 'quantity');
        $product_id = $product_transferInfo['product'];
        $product_quantity = $product_transferInfo['quantity'];

        $product_transfer = array_combine($product_id, $product_quantity);

        $dataToAttach = array();
        foreach ($product_transfer as $key => $value) {
            $dataToAttach[$key] = [ 
                'quantity'=>$value,
            ];
        }
        



        $transfer = new Transfer();
        $transfer->source_warehouse_id = $request->source_warehouse_id;
        $transfer->destination_warehouse_id = $request->destination_warehouse_id;
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
        //
    }


    /**
     * Confirm the transfer to send.
     */
    public function confirmTransfer(Transfer $transfer)
    {
        // La funcion confirma que el stock este existente y lo resta. De igual manera añade el stock al almacen de destino

        dump($transfer);

        $transfer;
        /* return view('transfers-show',
        [
            // Send $transfer item
            'transfer' => $transfer,
        ]); */
    }
}
