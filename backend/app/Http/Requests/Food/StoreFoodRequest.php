<?php

namespace App\Http\Requests\Food;

use App\Enums\FoodCategory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreFoodRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:foods,name',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category' => ['required', Rule::in([FoodCategory::MAKANAN, FoodCategory::MINUMAN])],
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'is_available' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Food name is required',
            'name.unique' => 'Food name already exists',
            'price.required' => 'Price is required',
            'price.numeric' => 'Price must be a number',
            'price.min' => 'Price must be greater than or equal to 0',
            'category.required' => 'Category is required',
            'category.in' => 'Category must be either makanan or minuman',
            'image.image' => 'File must be an image',
            'image.max' => 'Image size must not exceed 2MB',
        ];
    }
}
