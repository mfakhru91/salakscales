<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bookkeeping_journal;
use Carbon\Carbon;
use App\JournalLedger;
use Auth;

class AdditionalItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $from = $request->get('from');
        $to = $request->get('to');
        $date = Carbon::now()->timezone('Asia/Jakarta')->format('Y-m-d');
        if ($from == null) {
            $month_item =  Bookkeeping_journal::where('user_id', Auth::id())
                ->where('date', $date)
                ->get();
        } elseif ($to == null) {
            $month_item =  Bookkeeping_journal::where('user_id', Auth::id())
                ->where('date', $from)
                ->get();
        } else {
            $month_item =  Bookkeeping_journal::where('user_id', Auth::id())
                ->whereBetween('date', [$from, $to])
                ->get();
        }
        return view('users.additional-item.index', [
            'month_item' => $month_item,
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
        $price = $request->get('item_unit') *  $request->get('item_price');

        $this->validate($request, [
            'date' => 'required',
            'item_name' => 'required',
            'item_unit' => 'required|numeric',
            'item_price' => 'required|numeric',
        ]);

        $bookkeeping_journal = new Bookkeeping_journal;
        $bookkeeping_journal->user_id = Auth::id();
        $bookkeeping_journal->date = $request->get('date');
        $bookkeeping_journal->name = $request->get('item_name');
        $bookkeeping_journal->unit = $request->get('item_unit');
        $bookkeeping_journal->price = $request->get('item_price');
        $bookkeeping_journal->save();

        // add data to generalledger
        $JournalLedger = new JournalLedger;
        $JournalLedger->user_id = Auth::id();
        $JournalLedger->description = "Pembelian ".$request->get('item_name');
        $JournalLedger->status = "kredit";
        $JournalLedger->nominal = $price;
        $JournalLedger->date = Carbon::now('m')->timezone('Asia/Jakarta')->format('Y-m-d');
        $JournalLedger->save();
        return redirect()->route('additional-item.index')->with('status', 'berhail menambahkan pembelian barang');
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
        return view('users.additional-item.edit', [
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
        return redirect()->route('additional-item.index')->with('status', 'berhail memperbarui pembelian barang');
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
        return redirect()->route('additional-item.index')->with('status', '1 barang berhasil dihapus');
    }

    public function export(Request $request)
    {
        $from = $request->get('from');
        $to = $request->get('to');
        $date = Carbon::now()->timezone('Asia/Jakarta')->fordmat('Y-m-d');
        if ($from == null) {
            $month_item =  Bookkeeping_journal::where('user_id', Auth::id())
                ->where('date', $date)
                ->get();
        } elseif ($to == null) {
            $month_item =  Bookkeeping_journal::where('user_id', Auth::id())
                ->where('date', $from)
                ->get();
        } else {
            $month_item =  Bookkeeping_journal::where('user_id', Auth::id())
                ->whereBetween('date', [$from, $to])
                ->get();
        }
        return view('users.additional-item.export', [
            'month_item' => $month_item,
        ]);
    }
}
