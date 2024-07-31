<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGalleryRequest extends FormRequest
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
            'image_url' => ['required', 'mimes:jpg,png,jpeg,webp', 'max:200000'],
            'title' => ['required', 'string', 'max:255'],
           
             
        ];
    }
    public function attributes()
    {
        return [
            'image_url' => 'image_url',
            'title' => 'title',
            'description' => 'description',
            
        ];
    }
}
