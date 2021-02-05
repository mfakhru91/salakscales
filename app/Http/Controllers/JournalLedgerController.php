<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\JournalLedger;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Bookkeeping_journal;
use App\Buyer;
use Auth;

class JournalLedgerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lastMonth = Carbon::now()->subMonth()->format('m');
        $additem =  Bookkeeping_journal::where('user_id', Auth::id())
            ->whereMonth('date', $lastMonth)
            ->get();

        $profit = Buyer::withCount(array('dvitem as price' => function ($query) use($lastMonth){
            return $query->select(DB::raw('sum(price)'))
                ->whereMonth('date_time', $lastMonth)
                ->where('status', '1');
        }))
            ->withCount(array('dvitem as income' => function ($query) use($lastMonth){
                return $query->select(DB::raw('sum(income)'))
                    ->whereMonth('date_time', $lastMonth)
                    ->where('status', '1');
            }))
            ->withCount(array('dvitem as tonase' => function ($query) use($lastMonth){
                return $query->select(DB::raw('sum(new_tonase)'))
                    ->whereMonth('date_time', $lastMonth)
                    ->where('status', '1');
            }))
            ->where('user_id', Auth::id())
            ->get();

        $data =  JournalLedger::where('user_id', Auth::id())
            ->whereMonth('created_at', Carbon::now('m')->timezone('Asia/Jakarta'))
            ->get();

        $lastDate = Carbon::now()->subMonth()->format('F');
        return view('users.jurnal-ledger.index', [
            'last_date' => $lastDate,
            'data' => $data,
            'additem' => $additem,
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
