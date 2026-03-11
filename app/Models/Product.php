<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'name',
        'price' => 'decimal:2', // or 'float'
        'image',
        'category',
        'description',
    ];
    public function seller()
{
    return $this->belongsTo(\App\Models\Seller::class, 'seller_id', 'id');
}

}