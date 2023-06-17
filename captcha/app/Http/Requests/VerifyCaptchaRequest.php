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
    //validator
    public $validator = null;

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

    public function bodyParameters() {
        return [
            'response' => [
                'description' => 'The user response to the captcha challenge: 0 to the images unclicked, 1 to the images clicked',
            ],
            'solution' => [
                'description' => 'The encrypted solution to the captcha challenge, passed as api/v1/generate response ',
                'example' => 'eyJpdiI6InNqNU9Fd0NkVUtEMDVsSDUyMjh5c1E9PSIsInZhbHVlIjoib3lqb2dNY0NBWjNYSWhsWUJZeVJXNTcreEVURkdZamovbWVIb3h',
            ],
            'keyNumber' => [
                'description' => 'The number of the key used to encrypt the solution, passed as api/v1/generate response ',
            ]
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator):void
    {
        $this->validator = $validator;
    }

}
