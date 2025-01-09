<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StockMovementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        $stock_movements = $this->route('stock_movements');

        return match ($this->route()?->getName()){
            'stock_movements.store' => [
                'ingredient_id' => 'required|exists:ingredients,id',
                'quantity' => 'required|integer|min:1',
                'description' => 'nullable|string',
            ],
            'stock_movements.update' => [
                'ingredient_id' => 'required|exists:ingredients,id' . $stock_movements->id,
                'quantity' => 'required|integer|min:1',
                'description' => 'nullable|string',
            ],
            default => []
        };
    }
    public function messages(): array
    {
        return [
            'ingredient_id.required' => 'Selecting an ingredient is required.',
            'ingredient_id.exists' => 'The selected ingredient does not exist.',
            'type.required' => 'Selecting a type is required.',
            'type.in' => 'Invalid type value.',
            'quantity.required' => 'Quantity is required.',
            'quantity.integer' => 'Quantity must be an integer.',
            'quantity.min' => 'Quantity must be at least 1.',
            'description.string' => 'Description must be a string.',
        ];
    }

}
