<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'users_id', 'categories_id', 'price', 'description', 'slug', 'variasi', 'jumlah','affiliate','komisi'
    ];

    protected $hidden = [

    ];

    public function galleries(){
        return $this->hasMany(productgallery::class, 'products_id','id');
    }

    public function user(){
        return $this->hasOne(User::class, 'id','users_id');
    }

    public function category(){
        return $this->belongsTo(category::class, 'categories_id', 'id');
    }
}
