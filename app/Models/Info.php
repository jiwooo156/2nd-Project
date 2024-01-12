<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use DateTimeInterface;

class Info extends Model
{
    use HasFactory, Notifiable, HasApiTokens, SoftDeletes;
    protected $guarded = ['id'];
    protected $table = 'infos';
    // public $timestamps = true; 기본값
    protected function serializeDate(DateTimeInterface $date){
        return $date->format('Y-m-d H:i:s');
    }
}
