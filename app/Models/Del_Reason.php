<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Del_Reason extends Model
{
    use HasFactory;
    protected $fillable = [
        'del_self_msg'
        ,'del_flg'
        ,'u_id'
    ];
    protected $table = 'del_reasons';
    public $timestamps = false;
}
