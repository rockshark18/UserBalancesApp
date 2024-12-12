<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetUserBalanceRequest extends FormRequest
{
    public function authorize(): bool {
        return true;
    }
}
