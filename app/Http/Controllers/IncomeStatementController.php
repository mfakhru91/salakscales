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
    public function index(Request $request)
    {
        $get_month = $request->get("month");
        if ($get_month == null) {
            $date_selected = null;
            $additionaltem =  Bookkeeping_journal::where('user_id', Auth::id())
                ->whereMonth('date', Carbon::now('m')->timezone('Asia/Jakarta'))
                ->get();

            $profit = Buyer::withCount(array('graded_item as price' => function ($query) {
                return $query->select(DB::raw('sum(price)'))
                    ->whereMonth('date_time', Carbon::now('m')->timezone('Asia/Jakarta'))
                    ->where('status', '1');
            }))
                ->withCount(array('graded_item as income' => function ($query) {
                    return $query->select(DB::raw('sum(income)'))
                        ->whereMonth('date_time', Carbon::now('m')->timezone('Asia/Jakarta'))
                        ->where('status', '1');
                }))
                ->withCount(array('graded_item as tonase' => function ($query) {
                    return $query->select(DB::raw('sum(new_tonase)'))
                        ->whereMonth('date_time', Carbon::now('m')->timezone('Asia/Jakarta'))
                        ->where('status', '1');
                }))
                ->where('user_id', Auth::id())
                ->get();
            //get day of this month
        } else {
            $get_month = explode("-", $request->input('month'));
            $date_selected = $request->get("month");
            $year = str_replace(' ', '', $get_month[0]);
            $month = str_replace(' ', '', $get_month[1]);

            $additionaltem =  Bookkeeping_journal::where('user_id', Auth::id())
                ->whereMonth('date', $month)
                ->whereYear('date', $year)
                ->get();

            $profit = Buyer::withCount(array('graded_item as price' => function ($query) use ($month, $year) {
                return $query->select(DB::raw('sum(price)'))
                    ->whereMonth('date_time', $month)
                    ->whereYear('date_time', $year)
                    ->where('status', '1');
            }))
                ->withCount(array('graded_item as income' => function ($query) use ($month, $year) {
                    return $query->select(DB::raw('sum(income)'))
                        ->whereMonth('date_time', $month)
                        ->whereYear('date_time', $year)
                        ->where('status', '1');
                }))
                ->withCount(array('graded_item as tonase' => function ($query) use ($month, $year) {
                    return $query->select(DB::raw('sum(new_tonase)'))
                        ->whereMonth('date_time', $month)
                        ->whereYear('date_time', $year)
                        ->where('status', '1');
                }))
                ->where('user_id', Auth::id())
                ->get();
        }

        // get year income
        $additionaltemYear =  Bookkeeping_journal::where('user_id', Auth::id())
            ->whereYear('date', Carbon::now('y')->timezone('Asia/Jakarta'))
            ->get();

        $profitYear = Buyer::withCount(array('dvitem as price' => function ($query) {
            return $query->select(DB::raw('sum(price)'))
                ->whereYear('date_time', Carbon::now('y')->timezone('Asia/Jakarta'))
                ->where('status', '1');
        }))
            ->withCount(array('graded_item as income' => function ($query) {
                return $query->select(DB::raw('sum(income)'))
                    ->whereYear('date_time', Carbon::now('y')->timezone('Asia/Jakarta'))
                    ->where('status', '1');
            }))
            ->withCount(array('graded_item as tonase' => function ($query) {
                return $query->select(DB::raw('sum(new_tonase)'))
                    ->whereYear('date_time', Carbon::now('y')->timezone('Asia/Jakarta'))
                    ->where('status', '1');
            }))
            ->where('user_id', Auth::id())
            ->get();

        $start = Carbon::now()->startOfMonth()->format('d F y');
        $end = Carbon::now()->endOfMonth()->format('d F y');
        return view('users.income-statement.index', [
            'profit' => $profit,
            'additem' => $additionaltem,
            'start_day' => $start,
            'end_day' => $end,
            'date_selected' => $date_selected,
            'additionaltemYear' => $additionaltemYear,
            'profitYear' => $profitYear

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

    public function detaildata()
    {
        $data = [];
        for ($i = 1; $i <= 12; $i++) {
            $income_arr = [];
            $additionaltem_arr = [];
            $income = Buyer::withCount(array('graded_item as price' => function ($query) use ($i) {
                return $query->select(DB::raw('sum(price)'))
                    ->whereMonth('date_time', $i)
                    ->where('status', '1');
            }))
                ->withCount(array('graded_item as income' => function ($query) use ($i) {
                    return $query->select(DB::raw('sum(income)'))
                        ->whereMonth('date_time', $i)
                        ->where('status', '1');
                }))
                ->withCount(array('graded_item as tonase' => function ($query) use ($i) {
                    return $query->select(DB::raw('sum(new_tonase)'))
                        ->whereMonth('date_time', $i)
                        ->where('status', '1');
                }))
                ->where('user_id', Auth::id())
                ->get();

            $additionaltem =  Bookkeeping_journal::where('user_id', Auth::id())
                ->whereMonth('date', $i)
                ->get();
            
            foreach ($additionaltem as $item ) {
                $total_additional_items = $item->unit * $item->price;
                array_push($additionaltem_arr, $total_additional_items);
            }

            foreach ($income as $income) {
                $total_akomodasi = $income->tools * $income->tonase + $income->packing * $income->tonase + $income->shipping_charges * $income->tonase;
                $sum_income = $income->income - $income->price - $total_akomodasi;
                array_push($income_arr, $sum_income);
            }
            $sum_income = array_sum($income_arr);
            $sum_additem = array_sum($additionaltem_arr);
            $total = $sum_income - $sum_additem;
            array_push($data,$total);
        }
        return view('users.income-statement.detail', [
            'income' => $data,
        ]);
    }
}
