<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Dvitem;
use App\Buyer;
use Auth;

class DvitemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $userId = Auth::id();
        $dvitem = Dvitem::findOrFail($id);
        $buyer = Buyer::where('id', $dvitem->buyer_Id)->first();
        return view('users.dvbarang.edit', [
            'buyer' => $buyer,
            'item' => $dvitem,
            'user' => $userId
        ]);
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
        $this->validate($request, [
            'status' => 'required',
        ]);
        $dvitem = Dvitem::findOrFail($id);
        $dvitem->price = $request->get('price');
        $dvitem->income = $request->get('income');
        $dvitem->status = $request->get('status');
        $dvitem->save();
        $buyerId = $request->get('buyerId');
        return redirect()->route('penjualan.show', $buyerId)->with('status', 'Pengiriman berhasil diperbarui');
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

    public function deliveryUpdate(Request $request){
        $dvitem = Dvitem::findOrFail($request->get('item_id'));
        $buyerId = $request->get('buyer_id');
        if($dvitem->income == null){
            return redirect()->route('penjualan.show', $buyerId)->with('error', 'harap mengisi penjualan terlebh dahulu');
        }else{
            $dvitem->status = '1';
        $dvitem->save();
        return redirect()->route('penjualan.show', $buyerId)->with('status', 'Pengiriman berhasil diperbarui');
        }

    }
}
