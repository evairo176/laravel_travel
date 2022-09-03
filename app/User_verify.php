<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_verify extends Model
{
    public $table = "users_verify";

    /**
     * Write code on Method
     *
     * @return response()
     */
    protected $fillable = [
        'user_id',
        'token',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
