<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServicesModel extends Model
{
    //
    protected $table = 'services';
    protected $primaryKey = 'user_id';


    public function inventory()
    {
        return $this->belongsTo('App\InventoryModel', 'inventory_id');
    }

    public function client()
    {
        return $this->belongsTo('App\ClientsModel', 'client_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

}
