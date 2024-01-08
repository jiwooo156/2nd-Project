<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use DateTimeInterface;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'name',
        'nick',
        'phone',
        'birthdate',
        'password',
        'gender',
        'updated_at',
        'created_at',
        'deleted_at',
        'del_flg',
        'del_msg',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];
    protected function serializeDate(DateTimeInterface $date){
        return $date->format('Y-m-d H:i:s');
    }
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    // 필요 없다고 반장님이 지우라 함
    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];
}
