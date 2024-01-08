<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DateTimeInterface;

class restraint extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = ['id']; 
    protected $table = 'restraints';
    protected function serializeDate(DateTimeInterface $date){
        return $date->format('Y-m-d H:i:s');
    }
}
