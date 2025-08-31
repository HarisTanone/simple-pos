<?php

namespace App\Http\Requests\Food;

use App\Enums\FoodCategory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateFoodRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255', Rule::unique('foods')->ignore($this->food)],
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category' => ['required', Rule::in([FoodCategory::MAKANAN, FoodCategory::MINUMAN])],
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'is_available' => 'boolean',
        ];
    }
}
