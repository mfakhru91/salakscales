<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Bookkeeping_journal;
use App\Buyer;
use Auth;

class IncomeStatementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $additionaltem =  Bookkeeping_journal::where('user_id', Auth::id())
            ->whereMonth('date', Carbon::now('m')->timezone('Asia/Jakarta'))
            ->get();

        $profit = Buyer::withCount(array('dvitem as price' => function ($query) {
            return $query->select(DB::raw('sum(price)'))
                ->whereMonth('date_time', Carbon::now('m')->timezone('Asia/Jakarta'))
                ->where('status', '1');
        }))
            ->withCount(array('dvitem as income' => function ($query) {
                return $query->select(DB::raw('sum(income)'))
                    ->whereMonth('date_time', Carbon::now('m')->timezone('Asia/Jakarta'))
                    ->where('status', '1');
            }))
            ->withCount(array('dvitem as tonase' => function ($query) {
                return $query->select(DB::raw('sum(new_tonase)'))
                    ->whereMonth('date_time', Carbon::now('m')->timezone('Asia/Jakarta'))
                    ->where('status', '1');
            }))
            ->where('user_id', Auth::id())
            ->get();
        //get day of this month
        $startDate = Carbon::now();
        $start = Carbon::now()->startOfMonth()->format('d F y');
        $end = Carbon::now()->endOfMonth()->format('d F y');
        return view('users.income-statement.index', [
            'profit' => $profit,
            'additem' => $additionaltem,
            'start_day' => $start,
            'end_day' => $end

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
