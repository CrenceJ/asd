<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrdersModel extends Model
{
    //
    protected $table = 'orders';
    protected $primaryKey = 'order_id';

    public function clients()
    {
        return $this->belongsTo('App\ClientsModel', 'client_id');
    }

    public function details()
    {
        return $this->hasMany('App\OrderDetailsModel', 'order_id');
    }
}
