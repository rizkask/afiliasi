<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{

    protected $table='transactions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'users_id',
        'payment_url',
        'shipping_price',
        'transaction_status',
        'total_price',
        'code',
        'ekspedisi',
        'bayar_time',
        'shipping_time'

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];
    
    public function user(){
        return $this->belongsTo(user::class, 'users_id','id');
    }

    public function details(){
        return $this->hasMany( TransactionDetail::class, 'transactions_id', 'id' );
    }
}
