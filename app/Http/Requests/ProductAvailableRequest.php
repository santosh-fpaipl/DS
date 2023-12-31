<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseRequest;

class ProductAvailableRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'check' => ['nullable', 'in:available'],
        ];
    }
}
