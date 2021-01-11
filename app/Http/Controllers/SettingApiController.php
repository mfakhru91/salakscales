<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Setting;
use App\Http\Resources\Setting as SettingResource;
class SettingApiController extends Controller
{
    public function getData($id)
    {

        $getSetting = Setting::where('user_id', $id)->get();
        return SettingResource::collection($getSetting);
    }
}
