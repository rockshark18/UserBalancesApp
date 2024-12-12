<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_email'    => 'required|email',
            'amount'        => 'required|numeric',
            'description'   => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'user_email.required' => 'The user_email field is required.',
            'user_email.email'    => 'Please provide a valid email address.',
            'amount.required'     => 'The amount field is required.',
            'amount.numeric'      => 'The amount must be a number.',
            'description.required'=> 'The description field is required.',
            'description.string'  => 'The description must be a string.',
            'description.max'     => 'The description cannot exceed 255 characters.',
        ];
    }
}
