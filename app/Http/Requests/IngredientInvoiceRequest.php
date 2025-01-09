<?php

namespace App\Http\Requests;

use App\Enums\StatusEnum;
use Illuminate\Foundation\Http\FormRequest;

class IngredientInvoiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $ingredient_invoices = $this->route('ingredient_invoices');

        return match ($this->route()?->getName()){
            'ingredient_invoices.store' => [
                'name' => 'required|string|max:50',
            ],
            'ingredient_invoices.update' => [
                'name' => 'required|string|max:50' .$ingredient_invoices->id,
            ],
            default => []
        };
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Name is required.',
            'name.max' => 'Name must not exceed 50 characters.',
            'status.required' => 'Status is required.',
            'status.in' => 'Status has an invalid value.',
        ];
    }

}
