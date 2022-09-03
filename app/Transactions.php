<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transactions extends Model
{
    use SoftDeletes;
    protected $table = 'transactions';
    protected $fillable = [
        'travel_packages_id', 'users_id', 'additional_visa',
        'transaction_total', 'transaction_status'
    ];


    public function details()
    {
        return $this->hasMany(TransactionDetails::class, 'transactions_id', 'id');
    }
    public function travel_package()
    {
        return $this->belongsTo(TravelPackage::class, 'travel_packages_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }
}
