<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class BreweriesRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'page' => 'integer|min:1',
            'per_page' => 'integer|min:1|max:200',
        ];
    }

    public function messages(): array
    {
        return [
            'page.integer' => 'Il parametro "page" deve essere un numero intero.',
            'page.min' => 'Il parametro "page" non può essere minore di 1.',
            'per_page.integer' => 'Il parametro "per_page" deve essere un numero intero.',
            'per_page.min' => 'Il parametro "per_page" non può essere minore di 1.',
            'per_page.max' => 'Il parametro "per_page" non può superare 200.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'I dati forniti non sono validi.',
            'errors'  => $validator->errors()
        ], 422));
    }
}
