<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Dvitem;
use App\Buyer;
use Auth;


class ReportingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dvitem =  Dvitem::where('user_id', Auth::id())->get();
        $buyer = Buyer::where('user_id', Auth::id())->get();
        return view('users.laporan.index', [
            'dvitem' => $dvitem,
            'buyer' => $buyer,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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
        //
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

    public function searchMont(Request $request)
    {
        $dvitem =  Dvitem::where('user_id', Auth::id())
        ->whereDate('date_time',$request->get('cari'))
        ->get();
        $buyer = Buyer::where('user_id', Auth::id())->get();
        return view('users.laporan.index', [
            'dvitem' => $dvitem,
            'buyer' => $buyer,
        ]);
    }
}
