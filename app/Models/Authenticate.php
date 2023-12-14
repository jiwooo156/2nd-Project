<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Authenticate extends Model
{
    use HasFactory;
    protected $fillable = [
        'email'
        ,'auth_token'
        ,'auth_flg'
    ];
    protected $table = 'authenticates';
    public $timestamps = false;
}
