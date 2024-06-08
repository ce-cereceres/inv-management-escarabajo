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
            'name' => 'required',
            'price' => 'required',
            'sku' => 'required',
            'description' => 'required',
            'category_id' => 'required',
            'warehouses' => 'required',
            'warehouses.*.id' => [
                'required',
                Rule::exists('warehouses')->where(function ($query) use ($loggedInUserId){
                    $query->where('user_id', $loggedInUserId);
                }),
            ],
            'warehouse.*.quantityAvailable' => 'required',
        ];


        return $rules;
    }
}
