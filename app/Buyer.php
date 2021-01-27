<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Buyer extends Model
{
  public function dvitem()
  {
    return $this->hasMany('App\Dvitem');
  }

  public function dvitem_delivery()
  {
    return $this->dvitem()->where('status', '0')->whereMonth('date_time', Carbon::now('m')->timezone('Asia/Jakarta'));
  }

  public function item()
  {
    return $this->hasMany('App\Dvitem');
  }
}
