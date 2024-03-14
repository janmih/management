<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StockServiceRequest extends FormRequest
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
        return [
            'service_id' => 'required|exists:services,id',
            'designation' => 'required|string|max:255',
            'reference_article' => 'required|string|max:255',
            'stock_initial' => 'required|integer|min:0',
            'entree' => 'nullable|integer|min:0',
            'sortie' => 'nullable|integer|min:0',
            'stock_final' => 'required|integer|min:0',
        ];
    }
}
