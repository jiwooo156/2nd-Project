<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;
use Illuminate\Database\Eloquent\SoftDeletes;

class Replie extends Model
{
    use HasFactory,SoftDeletes;
    // protected $fillable = [
    //     'del_self_msg'
    //     ,'del_flg'
    //     ,'u_id'
    // ];
    // 1219 수정 최정훈 가디드도 써볼려고
    protected $guarded = ['id']; 
    
    protected $table = 'replies';
    protected function serializeDate(DateTimeInterface $date){
        return $date->format('Y-m-d H:i:s');
    }
}
