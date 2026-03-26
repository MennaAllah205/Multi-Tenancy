<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TenantUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|max:255',
            'db_name' => 'sometimes|string|max:255|unique:tenants,db_name,'.$this->tenant->id,
            'db_user' => 'sometimes|nullable|string|max:255',
            'db_password' => 'nullable|string|min:6',
        ];
    }
}
