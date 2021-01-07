<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Setting;
use App\Http\Resources\Setting as SettingResource;
class SettingApiController extends Controller
{
    public function getData()
    {
        $getSetting = Setting::all();
        return SettingResource::collection($getSetting);
    }
}
