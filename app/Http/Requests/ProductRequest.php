<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
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

      
        // Rules
        $rules = [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|between: 0.01, 4294967294.99',
            'sku' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'category_id' => 'required|numeric|exists:categories,id',
            'warehouses' => 'required',
            'warehouses.*.id' => [
                'required',
                Rule::exists('warehouses')->where(function ($query) use ($loggedInUserId){
                    $query->where('user_id', $loggedInUserId);
                }),
            ],
            'warehouses.*.quantityAvailable' => 'required|numeric|min:0|max:4294967294',
            'barcode' => 'string|nullable'
        ];


        return $rules;
    }
}
