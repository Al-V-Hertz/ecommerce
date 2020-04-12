<?php

namespace App;
use App\User;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guard_name = 'web';
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
