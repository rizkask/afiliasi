<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class bukti extends Model
{
    use SoftDeletes;

    protected $table='bukti';

    protected $fillable = [
        'image', 'claim_id','confirm'
    ];

    protected $hidden = [

    ];

    public function claim(){
        return $this->belongsTo(claim::class, 'claim_id','id');
    }
}
