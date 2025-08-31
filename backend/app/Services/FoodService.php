<?php

namespace App\Services;

use App\Models\Food;
use App\Http\Resources\FoodResource;
use App\Utils\ResponseHelper;
use App\Utils\ImageUploadHelper;
use App\Enums\FoodCategory;

class FoodService
{
    public function getAllFoods()
    {
        $foods = Food::orderBy('category')->orderBy('name')->get();

        return ResponseHelper::success(FoodResource::collection($foods));
    }

    public function getFoodsByCategory(string $category)
    {
        try {
            $categoryEnum = FoodCategory::fromKey(strtoupper($category));
            $foods = Food::where('category', $categoryEnum->value)
                ->where('is_available', true)
                ->orderBy('name')
                ->get();

            return ResponseHelper::success(FoodResource::collection($foods));
        } catch (\InvalidArgumentException $e) {
            return ResponseHelper::error('Invalid category', 400);
        }
    }

    public function createFood(array $data)
    {
        try {
            if (isset($data['image'])) {
                $data['image'] = ImageUploadHelper::upload($data['image']);
            }

            $food = Food::create($data);

            return ResponseHelper::success(new FoodResource($food), 'Food created successfully', 201);
        } catch (\Exception $e) {
            return ResponseHelper::error('Failed to create food: ' . $e->getMessage(), 500);
        }
    }

    public function getFoodById(int $id)
    {
        $food = Food::find($id);

        if (!$food) {
            return ResponseHelper::error('Food not found', 404);
        }

        return ResponseHelper::success(new FoodResource($food));
    }

    public function updateFood(int $id, array $data)
    {
        $food = Food::find($id);

        if (!$food) {
            return ResponseHelper::error('Food not found', 404);
        }

        try {
            if (isset($data['image'])) {
                // hapus gambar lama jika ada
                ImageUploadHelper::delete($food->image);
                $data['image'] = ImageUploadHelper::upload($data['image']);
            }

            $food->update($data);

            return ResponseHelper::success(new FoodResource($food), 'Food updated successfully');
        } catch (\Exception $e) {
            return ResponseHelper::error('Failed to update food: ' . $e->getMessage(), 500);
        }
    }

    public function deleteFood(int $id)
    {
        $food = Food::find($id);

        if (!$food) {
            return ResponseHelper::error('Food not found', 404);
        }

        try {
            // hapus gambar
            ImageUploadHelper::delete($food->image);

            $food->delete();

            return ResponseHelper::success(null, 'Food deleted successfully');
        } catch (\Exception $e) {
            return ResponseHelper::error('Failed to delete food: ' . $e->getMessage(), 500);
        }
    }
}
