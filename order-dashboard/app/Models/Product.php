<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'created_at',
        'updated_at',
        'name',
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function price()
    {
        return $this->hasOne(Price::class);
    }
}
