<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Setting;
use App\User;
use Auth;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $getUser = Auth::user();
        $getSetting = Setting::where('user_id', Auth::id())->first();
        $Setting = json_decode($getSetting);
        if (empty($Setting)) {
            $newSetting = new Setting;
            $newSetting->user_id = Auth::id();
            $newSetting->save();
            return view('users.setting.index');
        } else {
            return view('users.setting.index', [
                'settings' => $getSetting,
                'user' => $getUser,
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $updateUser = User::findOrFail($id);
        $updateUser->name = $request->get('username');
        $updateUser->save();
        $Setting = Setting::where('user_id', $id)
            ->update([
                'user_id' => Auth::id(),
                'price' => $request->get('price'),
                'tools_id' => $request->get('tools'),
                'sell_price' => $request->get('sellprice')
            ]);
        return redirect()->route('setting.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
