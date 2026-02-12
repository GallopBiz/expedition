<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
        ];
        if ($this->user() && $this->user()->role === 'Supplier') {
            $rules['company_name'] = ['nullable', 'string', 'max:255'];
            $rules['company_address'] = ['nullable', 'string', 'max:255'];
            $rules['contact1_name'] = ['nullable', 'string', 'max:255'];
            $rules['contact1_position'] = ['nullable', 'string', 'max:255'];
            $rules['contact1_mail'] = ['nullable', 'email', 'max:255'];
            $rules['contact1_mobile'] = ['nullable', 'string', 'max:50'];
            $rules['contact1_phone'] = ['nullable', 'string', 'max:50'];
            $rules['contact2_name'] = ['nullable', 'string', 'max:255'];
            $rules['contact2_position'] = ['nullable', 'string', 'max:255'];
            $rules['contact2_mail'] = ['nullable', 'email', 'max:255'];
            $rules['contact2_mobile'] = ['nullable', 'string', 'max:50'];
            $rules['contact2_phone'] = ['nullable', 'string', 'max:50'];
        }
        return $rules;
    }
}
