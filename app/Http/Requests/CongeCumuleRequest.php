<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CongeCumuleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->hasAnyRole('Ressource Humaine', 'Super Admin') ? true : false;
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
            'annee' => 'required|integer',
            'jour_total' => 'required|integer',
            'jour_prise' => 'required|integer',
            'jour_reste' => 'required|integer',
        ];
    }
}
