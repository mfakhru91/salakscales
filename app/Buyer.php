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
  public function graded_item()
  {
    return $this->hasMany('App\Graded_item');
  }
  public function graded_item_delivery()
  {
    return $this->graded_item()->where('status', '0')->whereMonth('date_time', Carbon::now('m')->timezone('Asia/Jakarta'));
  }

  public function count_dvitem()
  {
    return $this->dvitem()->where('status', '1');
  }

  public function item()
  {
    return $this->hasMany('App\Dvitem');
  }
}
