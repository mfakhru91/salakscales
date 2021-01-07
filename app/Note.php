<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Note extends Model
{
	public function date($value)
    {
      return Carbon::createFromFormat('Y-m-d H:i:s', $value )->format('d M Y');
    }
    public function item()
    {
    	return $this->hasMany('App\Item');
    }
}
