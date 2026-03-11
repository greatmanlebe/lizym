<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Seller extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'location',
        'slug',
        'number',
                'certification_status',

    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    public function getRouteKeyName()
    {
        return 'slug';
    }
public function documents()
{
    return $this->hasMany(\App\Models\SellerDocument::class, 'seller_id', 'id');
}

public function products()
{
    return $this->hasMany(\App\Models\Product::class, 'seller_id', 'id');
}

}
