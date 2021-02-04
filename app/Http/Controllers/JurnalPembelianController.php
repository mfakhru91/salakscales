<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Seller;
use App\Item;
use Auth;

class JurnalPembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $date_from  = $request->get('date_from');
        $date_to  = $request->get('date_to');
        $pembayaran = $request->get('payment');

        //Get Datas Seller & Item
        if ($date_from == null && $pembayaran == null) {
            $seller = null;
            $seller_item = null;
        } elseif ($date_from == null) {
            $seller = Seller::where('user_id', Auth::id())
                ->get();
            $seller_item = Item::where('delivery', '1')->where('payment', $pembayaran)->get();
        } elseif ($date_to == null) {
            $seller = Seller::where('user_id', Auth::id())
                ->get();
            $seller_item = Item::where('delivery', '1')->whereDate('created_at', $date_from)->get();
        } elseif ($pembayaran == null) {
            $seller = Seller::where('user_id', Auth::id())
                ->get();
            $seller_item = Item::where('delivery', '1')->whereBetween('created_at', [$date_from, $date_to])->get();
        } else {
            $seller = Seller::where('user_id', Auth::id())
                ->get();
            $seller_item = Item::where('delivery', '1')->where('payment', $pembayaran)->whereBetween('created_at', [$date_from, $date_to])->get();

        }
        return view('users.jurnal-pembelian.index', [
            'seller' => $seller,
            'seller_item' => $seller_item,
            'datefrom' => $date_from,
            'dateto' => $date_to,
            'pembayaran' => $pembayaran,
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
}
