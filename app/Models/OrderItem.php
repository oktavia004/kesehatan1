<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $primaryKey = 'order_item_id';
    public $timestamps = false;
    protected $fillable = [
        'order_id', 'product_id', 'quantity', 'price'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
