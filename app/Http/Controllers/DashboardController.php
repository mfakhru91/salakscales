<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use App\Seller;
use App\Metal;
use Auth;
class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get data date from asoia jakarta
        $date = Carbon::now('Asia/Jakarta')->timezone('Asia/Jakarta');

        // get data seller with item price count in this month
        $seller = Seller::withCount(array('item as total_price'=> function($query){
            return $query->select(DB::raw('sum(price)'))
                        ->where('status','sold')
                        ->whereMonth('created_at', Carbon::now('m')->timezone('Asia/Jakarta'));
        }))
        ->where('user_id',Auth::id())
        ->get();

        // get data seller with item price count in this year
        $priceyear  = Seller::withCount(array('item as total_price'=> function($query){
            return $query->select(DB::raw('sum(price)'))
                        ->where('status','sold')
                        ->whereYear('created_at', Carbon::now('Y')->timezone('Asia/Jakarta'));
        }))
        ->where('user_id',Auth::id())
        ->get();

        //get data seller with item count
        $item = Seller::withCount(array('item as item_count'=>function($query){
            $query->where('payment','paid off');
        }))
        ->where('user_id',Auth::id())
        ->get();

        // get data DEBT
        $debt = Seller::withCount(array('item as debt'=> function($query){
            return $query->select(DB::raw('sum(price)'))->where('payment','debt');
        }))
        ->where('user_id',Auth::id())
        ->get();

        // get data METAL
        $metal = Metal::where('user_id',Auth::id())->first();
        return view('users.dashboard.index',[
            'priceyear'=>$priceyear,
            'price'=>$seller,
            'item'=>$item,
            'debt'=>$debt,
            'metals'=>$metal
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
