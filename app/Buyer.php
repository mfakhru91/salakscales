<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Buyer extends Model
{
  public function dvitem()
  {
    return $this->hasMany('App\Dvitem');
  }
  public function item()
  {
    return $this->hasMany('App\Dvitem');
  }
}
