<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductFormRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {

        return [
            'name' => ['required', 'string'],
            'quantity' => ['required', 'numeric'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric'],
            'dis_price' => ['nullable', 'numeric'],
            'color' => ['nullable', 'string'],
            'tags' => ['nullable', 'string'],
            // 'image' => ['nullable', 'mimes:jpg,jpeg,png,webp'],
            'category' => ['required', 'numeric'], // Change 'category_id' to 'category'
            // 
            // 'size'=>['required', 'numeric'],
            // 'medium'=>['required', 'numeric'],
            // 'large'=>['required', 'numeric'],
            // 'xl'=>['required', 'numeric'],
            // 'xxl'=>['required', 'numeric'],

        ];
    }
}