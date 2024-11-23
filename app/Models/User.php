<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;

    protected $table = "users";

    protected $fillable = [
        'user',
        'birth',
        'gender',
        'foods',
    ];

    protected $casts = [
        'foods' => 'array',
    ];
}
