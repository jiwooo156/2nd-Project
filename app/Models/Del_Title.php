<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Del_Title extends Model
{
    use HasFactory;
    protected $fillable = [
        'del_msg'
        ,'del_flg'
    ];
    protected $primaryKey = 'del_flg';
    protected $table = 'del_titles';
    public $timestamps = false;
}
