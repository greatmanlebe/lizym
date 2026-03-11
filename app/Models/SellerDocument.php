<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellerDocument extends Model
{
    protected $table = 'seller_documents';

    protected $fillable = [
        'seller_id',
        'type',
        'file_path',
        'status',
        'admin_comment',
    ];

    public function seller()
    {
        return $this->belongsTo(Seller::class, 'seller_id', 'id');
    }
}