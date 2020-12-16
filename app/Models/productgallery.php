<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class productgallery extends Model
{
    use SoftDeletes;

    protected $table='product_galleries';

    protected $fillable = [
        'image', 'products_id'
    ];

    protected $hidden = [

    ];

    public function product(){
        return $this->belongsTo(product::class, 'products_id','id');
    }
}
