<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    // public function rules()
    // {
    //     return [
    //         'title' => ['required', 'max:2000'],
    //         'image' => ['nullable', 'image'],
    //         'price' => ['required', 'numeric'],
    //         'description' => ['nullable', 'string'],
    //         'published' => ['required', 'boolean']
    //     ];
    // }
    public function rules()
    {
        return [
            'title' => ['required', 'max:2000'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'max:2048'], // each image max 2MB
            'price' => ['required', 'numeric'],
            'description' => ['nullable', 'string'],
            'published' => ['required', 'boolean']
        ];
    }
}
