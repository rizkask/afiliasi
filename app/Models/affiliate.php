<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class affiliate extends Model
{
    use SoftDeletes;

    protected $table='affiliates';

    protected $fillable = [
        'users_id', 'products_id'
    ];

    protected $hidden = [

    ];

    public function user(){
        return $this->belongsTo(user::class, 'users_id','id');
    }

    public function product(){
        return $this->belongsTo(product::class, 'products_id','id');
    }
}
