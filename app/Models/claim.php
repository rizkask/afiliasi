<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class claim extends Model
{
    use SoftDeletes;

    protected $table='claim';

    protected $fillable = [
        'afiliator_id', 'total_claim','confirm'
    ];

    protected $hidden = [

    ];

    public function bukti(){
        return $this->hasOne(bukti::class, 'claim_id','id');
    }
}
