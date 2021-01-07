<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Buyer extends Model
{
    public function dvitem()
    {
      return $this->hasMany('App\Dvitem');
    }
}
