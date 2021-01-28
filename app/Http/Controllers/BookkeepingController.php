<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bookkeeping_journal;
use Auth;
class BookkeepingController extends Controller
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
        $month_item =  Bookkeeping_journal::findOrFail($id);
        return view('users.bookkeeping.edit', [
            'item' => $month_item,
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
            'date' => 'required',
            'item_name' => 'required',
            'item_unit' => 'required|numeric',
            'item_price' => 'required|numeric',
        ]);

        $bookkeeping_journal = Bookkeeping_journal::findOrFail($id);
        $bookkeeping_journal->user_id = Auth::id();
        $bookkeeping_journal->date = $request->get('date');
        $bookkeeping_journal->name = $request->get('item_name');
        $bookkeeping_journal->unit = $request->get('item_unit');
        $bookkeeping_journal->price = $request->get('item_price');
        $bookkeeping_journal->save();
        return redirect()->route('laporan.index')->with('status', 'berhail memperbarui pembelian barang');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }

    public function delete($id)
    {
        $items = Bookkeeping_journal::findOrFail($id);
        $items->delete();
        return redirect()->route('laporan.index')->with('status', '1 barang berhasil dihapus');
    }
}
