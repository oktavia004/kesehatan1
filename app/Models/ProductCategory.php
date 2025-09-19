<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;

    protected $table = 'product_categories';
    protected $primaryKey = 'category_id'; // <--- WAJIB! karena PK bukan 'id'

    protected $fillable = [
        'category_name',
    ];

    public $timestamps = false; // kalau tabelnya tidak punya created_at & updated_at
}
