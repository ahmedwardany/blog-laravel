<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class Subscriber extends Authenticatable
{
    use HasFactory, SoftDeletes,Notifiable,HasApiTokens;
    protected $table = 'subscribers';

    protected $fillable = [
        'name', 'username', 'email', 'password', 'status',
    ];

    protected $hidden = [
        'password',
    ];
}
