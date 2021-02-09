<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Dvitem;
use App\Buyer;
use App\JournalLedger;
use Carbon\Carbon;
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
        $buyer = Buyer::findOrFail($request->get('buyerId'));
        $dvitem = Dvitem::findOrFail($id);
        $dvitem->price = $request->get('price');
        $dvitem->income = $request->get('income');
        $dvitem->save();

        $JournalLedger = JournalLedger::where('dvitem_id',$id)->first();
        if ( $JournalLedger != null) {
            $JournalLedger->description = "Penjualan Ke Pasar " . $buyer->market;
            $JournalLedger->status = "debet";
            $JournalLedger->nominal = $request->get('income');
            $JournalLedger->date = Carbon::now()->timezone('Asia/Jakarta')->format('Y-m-d');
            $JournalLedger->save();
        }

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

    public function deliveryUpdate(Request $request)
    {

        $dvitem = Dvitem::findOrFail($request->get('item_id'));
        $buyer_id = $dvitem->buyer_Id;
        $buyer = Buyer::findOrFail($buyer_id);
        $buyerId = $request->get('buyer_id');
        if ($dvitem->income == null || $dvitem->income == 0) {
            return redirect()->route('penjualan.show', $buyerId)->with('error', 'harap mengisi penjualan terlebh dahulu');
        } else {
            $JournalLedger = new JournalLedger;
            $JournalLedger->user_id = Auth::id();
            $JournalLedger->description = "Penjualan Ke Pasar " . $buyer->market;
            $JournalLedger->status = "debet";
            $JournalLedger->nominal = $dvitem->income;
            $JournalLedger->dvitem_id = $request->get('item_id');
            $JournalLedger->date = Carbon::now()->timezone('Asia/Jakarta')->format('Y-m-d');
            $JournalLedger->save();

            $dvitem->status = '1';
            $dvitem->save();
            return redirect()->route('penjualan.show', $buyerId)->with('status', 'Pengiriman berhasil diperbarui');
        }
    }
    public function delete($id)
    {
        $dvitem = Dvitem::findOrFail($id);
        $JournalLedger = JournalLedger::where('dvitem_id',$id)->first();
        $dvitem->delete();
        $JournalLedger->delete();
        return redirect()->route('penjualan.show', $dvitem->buyer_Id)->with('status', 'Berhasil Menghapus Barang');
    }
}
