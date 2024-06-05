<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

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


        // Fetch all the warehouses from login user
        $warehouses = Auth::user()->warehouses;

        // Get individual elements from collection $warehouses
        foreach ($warehouses as $warehouse) {
            // Create an array with all warehouses from useers to use in validation
            

            $warehouseArrValidation[] = $warehouse->id;

            
        }

        // List to all warehouses string
        $warehouseList = implode(",", $warehouseArrValidation);
        
        // Rules
        $rules = [
            'name' => 'required',
            'price' => 'required',
            'sku' => 'required',
            'description' => 'required',
            'category_id' => 'required',
            'warehouse' => 'required',
            'warehouse.*' => 'required|in:'.$warehouseList,
        ];


        return $rules;
    }
}
