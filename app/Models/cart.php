<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class cart extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'products_id', 'users_id','quantity'
    ];

    protected $hidden = [

    ];

    public function product(){
        return $this->hasOne(product::class, 'id','products_id');
    }

    public function user(){
        return $this->belongsTo(user::class, 'users_id','id');
    }
}
