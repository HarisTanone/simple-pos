<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Food\StoreFoodRequest;
use App\Http\Requests\Food\UpdateFoodRequest;
use App\Services\FoodService;

class FoodController extends Controller
{
    protected $foodService;

    public function __construct(FoodService $foodService)
    {
        $this->foodService = $foodService;
    }

    public function index()
    {
        return $this->foodService->getAllFoods();
    }

    public function category($category)
    {
        return $this->foodService->getFoodsByCategory($category);
    }

    public function store(StoreFoodRequest $request)
    {
        return $this->foodService->createFood($request->validated());
    }

    public function show($id)
    {
        return $this->foodService->getFoodById($id);
    }

    public function update(UpdateFoodRequest $request, $id)
    {
        return $this->foodService->updateFood($id, $request->validated());
    }

    public function destroy($id)
    {
        return $this->foodService->deleteFood($id);
    }
}
