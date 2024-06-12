<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class TransferRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $loggedInUserId = Auth::user()->id;
        return [
            //
            'source_warehouse_id' => 'required|exists:warehouses,id,user_id,'.$loggedInUserId,
            'destination_warehouse_id' => 'required|exists:warehouses,id,user_id,'.$loggedInUserId,
            'product' => 'required',
            'product.*' => 'required|distinct:strict|exists:products,id,user_id,'.$loggedInUserId,
            'quantity' => 'required',
            'quantity.*' => 'required|numeric|min:1',
        ];
    }
}
