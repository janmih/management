<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AutorisatonAbsenceRequest extends FormRequest
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
            'personnel_id' => 'required|exists:personnels,id',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'jour_prise' => 'required|integer|min:0',
            'jour_reste' => 'required|integer|min:0',
            'motif' => 'nullable|string',
            'observation' => 'nullable|string',
            'status' => 'nullable|string',
        ];
    }
}
