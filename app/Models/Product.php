<?php

namespace App\Models;
 use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    // leaving out an explicit table name – Eloquent will use "products" by default.

    protected $fillable = [
        'name',
        'quantity',
        'price',
        'user_id',
        'category_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        // a product belongs to a category
        return $this->belongsTo(Category::class);
    }
}
