<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Buyer;
use App\Dvitem;
use Auth;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $buyers = Buyer::where('user_id', Auth::id())->get();
        return view('users.penjualan.index', [
            'buyers' => $buyers,
        ]);
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
        $this->validate($request, [
            'name' => 'required|min:5',
            'market' => 'required',
            'address' => 'required',
            'no_telp' => 'required|numeric',
        ]);
        $new_buyers = new Buyer;
        $new_buyers->user_id = Auth::id();
        $new_buyers->market = $request->get('market');
        $new_buyers->name = $request->get('name');
        $new_buyers->address = $request->get('address');
        $new_buyers->no_telp = $request->get('no_telp');
        $new_buyers->save();

        return redirect()->route('penjualan.index')->with('status', 'data penjualan baru telah ditambah');;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Auth::id();

        // get one row of delivered data
        $itemDelivered = Dvitem::orderBy('id', 'DESC')->take(1)
            ->where('user_id', $user)
            ->first();

        // check old tonase data
        if ($itemDelivered->old_tonase == null) {
            $data = Dvitem::Select('user_id', 'buyer_Id', 'date_time', 'new_tonase as tonase',)
                ->orderBy('id', 'DESC')->take(1)
                ->where('user_id', $user)
                ->first();
        } else {
            $data = Dvitem::Select('user_id', 'buyer_Id', 'date_time', 'old_tonase as tonase',)
                ->orderBy('id', 'DESC')->take(1)
                ->where('user_id', $user)
                ->first();
        }

        // get buyyer id
        $buyyers = Buyer::where('id', $id)->first();

        // get buyyer delivered item
        $buyyerDevItem = Dvitem::where('user_id', $user)
        ->where('buyer_id', $id)
        ->get();
        return view('users.penjualan.show', [
            'buyyers' => $buyyers,
            'user' => $user,
            'dvitem' => $data,
            'buyyerItem' => $buyyerDevItem
        ]);
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

    public function addItems(Request $request)
    {
        $date = Carbon::now()->format('Y-m-d');
        $addNewItem = new Dvitem;
        $addNewItem->user_id = Auth::id();
        $addNewItem->buyer_id =  $request->get('buyyer_id');
        $addNewItem->date_time = $date;
        $addNewItem->new_tonase = $request->get('new_tonase');
        $addNewItem->old_tonase = $request->get('old_tonase');
        $addNewItem->price = $request->get('price');
        $addNewItem->save();
        return redirect()->route('penjualan.show', $request->get('buyyer_id'))->with('status', 'berhasil menambahkan pengiriman baranh');
    }
}
