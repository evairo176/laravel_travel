<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Topup_transaction extends Model
{
    use SoftDeletes;
    protected $table = 'topup_transaction';
    protected $fillable = [
        'users_id', 'transaction_total', 'transaction_status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }
}
