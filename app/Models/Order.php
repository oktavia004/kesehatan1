<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $primaryKey = 'order_id';
    public $timestamps = false;
    protected $fillable = [
        'user_id', 'total_amount', 'payment_method', 'paypal_id', 'bank_name'
    ];
    protected $casts = [
        'order_date' => 'datetime',
    ];
    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
