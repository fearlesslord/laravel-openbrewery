<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest
{
    /**
     * Determina se l'utente è autorizzato ad effettuare questa richiesta.
     *
     * Puoi introdurre logiche di permessi/ruoli.
     * Se non hai restrizioni particolari, restituisci true.
     */
    public function authorize(): true
    {
        return true;
    }

    /**
     * Regole di validazione.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'user'     => 'required|string',
            'password' => 'required|string',
        ];
    }

    /**
     * Eventuali messaggi personalizzati.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'user.required' => 'Il campo user è obbligatorio.',
            'user.string'   => 'Il campo user deve essere una stringa.',
            'password.required' => 'La password è obbligatoria.',
            'password.string'   => 'La password deve essere una stringa.',
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
