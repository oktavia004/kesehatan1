<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // penting agar bisa dipakai untuk login
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Nama tabel di database
    protected $table = 'users';

    // Primary key
    protected $primaryKey = 'user_id';

    // Kolom yang boleh diisi mass-assignment
    protected $fillable = [
        'username',
        'password',
        'role',
        'email',
        'date_of_birth',
        'gender',
        'address',
        'city',
        'contact_no',
        'paypal_id',
    ];

    // Jangan tampilkan password saat model di-serialize
    protected $hidden = [
        'password',
    ];

    
}