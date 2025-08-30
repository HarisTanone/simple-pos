<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\FoodCategory;

class Food extends Model
{
    use HasFactory;

    protected $table = 'foods';

    protected $fillable = [
        'name',
        'description',
        'price',
        'category',
        'image',
        'is_available',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_available' => 'boolean',
        'category' => FoodCategory::class,
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
