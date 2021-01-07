<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dvitem extends Model
{
    public function buyer()
    {
      return $this->belongsTo('App\Buyer');
    }
}
