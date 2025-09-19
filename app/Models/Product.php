<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products'; // nama tabel

    protected $primaryKey = 'product_id'; // primary key di tabel

    public function getRouteKeyName()
    {
        return 'product_id';
    }

    protected $fillable = [
        'product_name',
        'product_code',
        'price',
        'stock',
        'description',   // ✅ Tambah
        'image_url',     // ✅ Tambah
        'category_id'
    ];

    // Relasi ke tabel product_categories
   public function category()
{
    return $this->belongsTo(ProductCategory::class, 'category_id', 'category_id');
}

public function carts()
    {
        return $this->hasMany(Cart::class, 'product_id');
    }
    
}
