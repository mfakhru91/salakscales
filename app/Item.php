<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Item extends Model
{
    public function sumPrice()
    {
      return $this->price->sum();
    }
    public function date($value)
    {
      return Carbon::createFromFormat('Y-m-d H:i:s', $value )->format('d M Y');
    }
    public function seller()
    {
      return $this->belongsTo('App\Saller');
    }
    public function note()
    {
      return $this->belongsTo('App\Note');
    }
}
