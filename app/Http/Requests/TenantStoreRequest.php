<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TenantStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:tenants,phone',
            'db_name' => 'required|string|max:255|unique:tenants,db_name',
            'db_user' => 'required|string|max:255',
            'db_password' => 'required|string|min:6',
        ];
    }
}
