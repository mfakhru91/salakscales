<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Dvitem;
use App\Buyer;
use App\Bookkeeping_journal;
use Auth;


class ReportingController extends Controller
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
        $market = $request->get('market_id');
        $additonal_date = $request->get('date_additional_item');

        if ($from == null && $to == null) {
            $dvitem =  null;
            $items = null;
            $profit = null;
        } elseif ($to == null) {
            $dvitem =  Dvitem::where('user_id', Auth::id())
                ->whereDate('date_time', $from)
                ->where('status', '1')
                ->orderBy('date_time', 'ASC')
                ->get();

            $items =  Bookkeeping_journal::where('user_id', Auth::id())
                ->whereDate('date', $from)
                ->orderBy('date', 'ASC')
                ->get();

            $profit = Buyer::withCount(array('dvitem as price' => function ($query) use ($from, $to, $market) {
                if ($market == null) {
                    return $query->select(DB::raw('sum(price)'))
                        ->whereDate('date_time', $from)
                        ->where('status', '1');
                } else {
                    return $query->select(DB::raw('sum(price)'))
                        ->where('buyer_id', $market)
                        ->whereDate('date_time', $from)
                        ->where('status', '1');
                }
            }))
                ->withCount(array('dvitem as income' => function ($query)  use ($from, $to, $market) {
                    if ($market == null) {
                        return $query->select(DB::raw('sum(income)'))
                            ->whereDate('date_time', $from)
                            ->where('status', '1');
                    } else {
                        return $query->select(DB::raw('sum(income)'))
                            ->where('buyer_id', $market)
                            ->whereDate('date_time', $from)
                            ->where('status', '1');
                    }
                }))
                ->withCount(array('dvitem as tonase' => function ($query) use ($from, $to, $market) {
                    if ($market == null) {
                        return $query->select(DB::raw('sum(new_tonase)'))
                            ->whereDate('date_time', $from)
                            ->where('status', '1');
                    } else {
                        return $query->select(DB::raw('sum(new_tonase)'))
                            ->where('buyer_id', $market)
                            ->whereDate('date_time', $from)
                            ->where('status', '1');
                    }
                }))
                ->where('user_id', Auth::id())
                ->get();
        } else {
            $dvitem =  Dvitem::where('user_id', Auth::id())
                ->whereBetween('date_time', [$from, $to])
                ->where('status', '1')
                ->orderBy('date_time', 'ASC')
                ->get();
            $items =  Bookkeeping_journal::where('user_id', Auth::id())
                ->whereBetween('date', [$from, $to])
                ->orderBy('date', 'ASC')
                ->get();

            $profit = Buyer::withCount(array('dvitem as price' => function ($query) use ($from, $to, $market) {
                if ($market == null) {
                    return $query->select(DB::raw('sum(price)'))
                        ->whereBetween('date_time', [$from, $to])
                        ->where('status', '1');
                } else {
                    return $query->select(DB::raw('sum(price)'))
                        ->whereBetween('date_time', [$from, $to])
                        ->where('buyer_id', $market)
                        ->where('status', '1');
                }
            }))
                ->withCount(array('dvitem as income' => function ($query)  use ($from, $to, $market) {
                    if ($market == null) {
                        return $query->select(DB::raw('sum(income)'))
                            ->whereBetween('date_time', [$from, $to])
                            ->where('status', '1');
                    } else {
                        return $query->select(DB::raw('sum(income)'))
                            ->whereBetween('date_time', [$from, $to])
                            ->where('buyer_id', $market)
                            ->where('status', '1');
                    }
                }))
                ->withCount(array('dvitem as tonase' => function ($query) use ($from, $to, $market) {
                    if ($market == null) {
                        return $query->select(DB::raw('sum(new_tonase)'))
                            ->whereBetween('date_time', [$from, $to])
                            ->where('status', '1');
                    } else {
                        return $query->select(DB::raw('sum(new_tonase)'))
                            ->whereBetween('date_time', [$from, $to])
                            ->where('buyer_id', $market)
                            ->where('status', '1');
                    }
                }))
                ->where('user_id', Auth::id())
                ->get();
        }
        if ($market == null) {
            $buyer = Buyer::where('user_id', Auth::id())
                ->get();
        } else {
            $buyer = Buyer::where('user_id', Auth::id())
                ->where('id', $market)
                ->get();
        }

        if ($additonal_date == null) {
            $month_item =  Bookkeeping_journal::where('user_id', Auth::id())->paginate('10');
        } else {
            $month_item =  Bookkeeping_journal::where('user_id', Auth::id())
                ->where('date', $additonal_date)
                ->paginate('10');
        }


        $select_buyer = Buyer::where('user_id', Auth::id())
            ->get();

        return view('users.laporan.index', [
            'dvitem' => $dvitem,
            'buyer' => $buyer,
            'select_buyer' => $select_buyer,
            'items' => $items,
            'month_item' => $month_item,
            'profit' => $profit
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
        return redirect()->route('laporan.index')->with('status', 'berhail menambahkan pembelian barang');
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
            ->whereDate('date_time', $request->get('cari'))
            ->get();
        $buyer = Buyer::where('user_id', Auth::id())->get();
        return view('users.laporan.index', [
            'dvitem' => $dvitem,
            'buyer' => $buyer,
        ]);
    }
}
