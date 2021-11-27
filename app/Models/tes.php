<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class tes extends Model
{
    protected $table='tes';
    protected $fillable = [
        'nama','nim','jenis_kelamin'
    ];
}