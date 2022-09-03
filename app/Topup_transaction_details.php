<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Topup_transaction_details extends Model
{
    use SoftDeletes;
    protected $table = 'topup_transaction_details';
    protected $fillable = [
        'topup_transaction_id', 'username', 'saldo'
    ];
}
