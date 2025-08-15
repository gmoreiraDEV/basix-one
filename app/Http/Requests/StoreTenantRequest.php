<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTenantRequest extends FormRequest
{
    public function authorize(): bool
    {
        // ajuste depois para checar se o usuário é admin
        return true;
    }

    public function prepareForValidation()
    {
        $slug = $this->input('slug');
        if (!$slug && $this->filled('name')) {
            $slug = \Illuminate\Support\Str::slug($this->input('name'));
        }
        if ($slug) {
            $this->merge(['slug' => \Illuminate\Support\Str::slug($slug)]);
        }
    }

    public function rules(): array
    {
        return [
            'name'           => ['required','string','max:150'],
            'slug'           => ['nullable','string','max:60','regex:/^[a-z0-9\-]+$/','unique:tenants,slug'],
            'domain'         => ['nullable','string','max:190','unique:tenants,domain'],
            'brand_name'     => ['nullable','string','max:150'],
            'email_from'     => ['nullable','email','max:190'],
            'primary_color'  => ['nullable','regex:/^#([A-Fa-f0-9]{3}|[A-Fa-f0-9]{6})$/'],
            'secondary_color'=> ['nullable','regex:/^#([A-Fa-f0-9]{3}|[A-Fa-f0-9]{6})$/'],
            'logo'           => ['nullable','image','mimes:jpg,jpeg,png,webp,svg','max:2048'],
        ];
    }


    public function messages(): array
    {
        return [
            'slug.regex' => 'Use apenas letras, números, hífen (-), underline (_) ou ponto (.)',
        ];
    }
}
