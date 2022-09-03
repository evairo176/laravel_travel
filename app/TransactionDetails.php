<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransactionDetails extends Model
{
    use SoftDeletes;
    protected $table = 'transaction_details';
    protected $fillable = [
        'transactions_id', 'username', 'nationality', 'is_visa', 'doe_passport'
    ];

    public function transaction()
    {
        return $this->belongsTo(Transactions::class, 'transaction_id', 'id');
    }
}
