<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Validator;

class StoreUserRequest extends FormRequest
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
            'user' => 'required|unique:users,user|regex:/^[a-zA-Z0-9_]+$/',
            'birth' => 'required|date|before:-18 years',
            'gender' => 'required|in:m,f',
            'foods' => 'nullable|array',
            'foods.*' => 'string'
        ];
    }

    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator): never {
        throw new HttpResponseException(
            response()->json([
                'message' => 'Validation failed.',
                'errors' => $validator->errors()
            ], 422)
        );
    }
}
