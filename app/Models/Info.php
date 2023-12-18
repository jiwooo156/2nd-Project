<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class Info extends Model
{
    use HasFactory, Notifiable, HasApiTokens, SoftDeletes;
    protected $fillable = [
        'id'
        ,'title'
        ,'content'
        ,'img1'
        ,'img2'
        ,'img3'
        ,'hits'
        ,'ns_flg'
        ,'states_flg'
        ,'main_flg'
        ,'place'
        ,'start_at'
        ,'end_at'
        ,'created_at'
        ,'updated_at'
        ,'deleted_at'
    ];
    protected $table = 'infos';
    // public $timestamps = true; 기본값
}
