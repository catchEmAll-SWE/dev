<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VerifyCaptchaRequest extends FormRequest
{

    /**
     * The URI that users should be redirected to if validation fails.
     *
     * @var string
     */
    protected $redirect = '/docs';

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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'response' => ['required','string','regex:/^(0|1){10}$/'], // 10 digits, each digit is 0 or 1
            'solution' => 'required|string',
            'keyNumber' => 'required|integer|min:0|max:19',
            
            'fixedStrings' => 'required|array|min:3|max:3',
            'fixedStrings.*' => 'required|string|min:21|max:22',
            'nonces' => 'required|array|min:3|max:3',
            'nonces.*' => 'required|string',
        ];
    }
}
