<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'code' => 'required|string',
            'category_id' => 'required|string',
            'details' => 'string',
            'cost_price' => 'required|numeric',
            'sale_price' => 'required|numeric',
            'initial_stock' => 'required|string',
            'total_stock' => 'required|string',
            'unit' => 'required|string',
            'user_id' => 'required|string'
        ];
    }
}
