<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{

    public function item()
    {
      return $this->hasMany('App\Item');
    }

    public function delivered_item()
    {
      return $this->item()->where('delivery', '1');
    }
}
