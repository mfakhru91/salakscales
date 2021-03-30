<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Graded_Item extends Model
{
    public function date($value)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $value)->format('d M Y');
    }
}
