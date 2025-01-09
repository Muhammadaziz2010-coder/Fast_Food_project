<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IngredientRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'measurement_id' => 'required|exists:measurements,id',
            'name' => 'required|string|max:255',
            'quantity' => 'required|numeric|min:0.01',
            'price' => 'required|numeric|min:0.01',
            'expiration_date' => 'nullable|date|after_or_equal:today',
            'description' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'measurement_id.required' => 'Measurement unit is required.',
            'measurement_id.exists' => 'The selected measurement unit is invalid.',
            'name.required' => 'Name is required.',
            'quantity.required' => 'Quantity is required.',
            'price.required' => 'Price is required.',
            'expiration_date.after_or_equal' => 'Expiration date must be after or equal to today.',
        ];
    }

}

