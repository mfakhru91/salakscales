<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Dvitem extends Model
{
  public function buyer()
  {
    return $this->belongsTo('App\Buyer');
  }
  public function date($value)
  {
    return Carbon::createFromFormat('Y-m-d H:i:s', $value)->format('d M Y');
  }
}
