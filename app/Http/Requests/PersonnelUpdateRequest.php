<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PersonnelUpdateRequest extends FormRequest
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
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'cin' => 'nullable|string|unique:personnels,cin,' . $this->personnel->id,
            'date_cin' => 'nullable|date',
            'com_cin' => 'nullable|string',
            'duplicata' => 'nullable',
            'date_duplicata' => 'nullable',
            'ddn' => 'nullable|date',
            'age' => 'nullable|integer',
            'genre' => 'nullable|string',
            'adresse' => 'nullable|string',
            'email' => 'nullable|email',
            'contact' => 'nullable|string',
            'fonction' => 'nullable|string',
            'matricule' => 'nullable|string',
            'indice' => 'string|nullable',
            'corps' => 'string|nullable',
            'grade' => 'string|nullable',
            'date_effet_avancement' => 'nullable|date',
            'fin_date_effet_avancement' => 'nullable|date',
            'classe' => 'string|nullable',
            'echelon' => 'string|nullable',
        ];
    }
}
