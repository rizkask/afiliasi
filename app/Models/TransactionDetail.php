<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransactionDetail extends Model
{

    protected $table='transaction_details';
    protected $appends = ['ref_status_label','commission', 'total'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'transactions_id',
        'products_id',
        'users_id',
        'price',
        'shipping_status',
        'resi',
        'quantity',
        'code',
        'ref',
        'bukti',
        'claims_id',
        'ref_status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public function transaction(){
        return $this->belongsTo(Transaction::class, 'transactions_id','id');
    }
    
    public function product(){
        return $this->hasOne(product::class, 'id','products_id');
    }

    public function getCommissionAttribute()
    {
        $commission = ($this->price * 10) / 100;
        return $commission > 10000 ? 10000:$commission;
    }
    
    public function getRefStatusLabelAttribute()
    {
        if ($this->ref_status == 0) {
            return '<span class="badge badge-secondary">Pending</span>';
        }
        return '<span class="badge badge-success">Diterima</span>';
    }
}
