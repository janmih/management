<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
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
            'reference_mouvement' => 'nullable',
            'compte_PCOP' => 'nullable',
            'reference' => 'nullable',
            'designation' => 'nullable',
            'conditionnement' => 'nullable',
            'unite' => 'nullable',
            'date_peremption' => 'nullable|date',
            'provenance' => 'nullable',
            'entree' => 'nullable|integer',
            'etat_article' => 'nullable',
        ];
    }
}
