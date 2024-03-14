<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SortieArticleRequest extends FormRequest
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
            'article_id' => 'required|exists:articles,id',
            'personnel_id' => 'required|exists:personnels,id',
            'quantity' => 'required|integer|min:1',
        ];
    }
}
