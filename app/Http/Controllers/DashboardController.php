<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Goutte\Client;

use Carbon\Carbon;
use App\Seller;
use App\Bookkeeping_journal;
use App\Buyer;
use App\Dvitem;
use Auth;
use Facade\Ignition\QueryRecorder\Query;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $states = [];
    public function index()
    {
        $hijri_year = \GeniusTS\HijriDate\Date::now()->format('Y');
        $hijri_mont = \GeniusTS\HijriDate\Date::now()->format('m');
        $hijri_day = \GeniusTS\HijriDate\Date::now()->format('d');
        $year_hijri_converter = \GeniusTS\HijriDate\Hijri::convertToGregorian($hijri_day, $hijri_mont, $hijri_year)->format('Y');
        $user_create_date = Auth::user()->created_at;
        $user_date_formate = Carbon::createFromFormat('Y-m-d H:i:s', $user_create_date)->format('Y-m-d');
        $user_hijri_month = \GeniusTS\HijriDate\Hijri::convertToHijri($user_date_formate)->format('m');
        // gold scraping
        $client = new Client();
        $page = $client->request('GET', 'https://www.logammulia.com/id');

        $page->filter('.current')->each(function ($item) {
            array_push($this->states, $item->text());
        });
        preg_match_all('!\d+!', $this->states[0], $matches);

        $goldprice = $matches[0][0] . $matches[0][1];

        // get data seller with item price count in this month
        $seller = Seller::withCount(array('item as total_price' => function ($query) {
            return $query->select(DB::raw('sum(price)'))
                ->where('status', 'sold')
                ->where('delivery', '1')
                ->whereMonth('created_at', Carbon::now('m')->timezone('Asia/Jakarta'));
        }))
            ->where('user_id', Auth::id())
            ->get();

        // get data seller with item price count in this year
        $priceyear  = Seller::withCount(array('item as total_price' => function ($query) use($year_hijri_converter){
            return $query->select(DB::raw('sum(price)'))
                ->where('status', 'sold')
                ->whereYear('created_at', $year_hijri_converter);
        }))
            ->where('user_id', Auth::id())
            ->get();

        //get delivered item
        $dvitems = Buyer::withCount('dvitem_delivery as dvcounting')->where('user_id', Auth::id())->get();

        // all items
        $deliveryItem = Buyer::withCount('dvitem as dvitem')
            ->where('user_id', Auth::id())
            ->get();

        // get data DEBT
        $debt = Seller::withCount(array('item as debt' => function ($query) {
            return $query->select(DB::raw('sum(price)'))
                ->where('delivery', '1')
                ->where('payment', 'debt');
        }))
            ->where('user_id', Auth::id())
            ->get();

        // income this year
        $yprofit = Buyer::withCount(array('dvitem as price' => function ($query) use($year_hijri_converter){
            return $query->select(DB::raw('sum(price)'))
                ->whereYear('date_time', $year_hijri_converter)
                ->where('status', '1');
        }))
            ->withCount(array('dvitem as income' => function ($query) use($year_hijri_converter){
                return $query->select(DB::raw('sum(income)'))
                    ->whereYear('date_time', $year_hijri_converter)
                    ->where('status', '1');
            }))
            ->withCount(array('dvitem as tonase' => function ($query) use($year_hijri_converter){
                return $query->select(DB::raw('sum(new_tonase)'))
                    ->whereYear('date_time', $year_hijri_converter)
                    ->where('status', '1');
            }))
            ->where('user_id', Auth::id())
            ->get();

        $yadditionaltem =  Bookkeeping_journal::where('user_id', Auth::id())
            ->whereMonth('date', Carbon::now('m')->timezone('Asia/Jakarta'))
            ->get();

        // income this month
        $mprofit = Buyer::withCount(array('dvitem as price' => function ($query) {
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

        $additionaltem =  Bookkeeping_journal::where('user_id', Auth::id())
            ->whereMonth('date', Carbon::now('m')->timezone('Asia/Jakarta'))
            ->get();

        // income this day
        $dprofit = Buyer::withCount(array('dvitem as price' => function ($query) {
            return $query->select(DB::raw('sum(price)'))
                ->whereDay('date_time', Carbon::now('d')->timezone('Asia/Jakarta'))
                ->where('status', '1');
        }))
            ->withCount(array('dvitem as income' => function ($query) {
                return $query->select(DB::raw('sum(income)'))
                    ->whereDay('date_time', Carbon::now('d')->timezone('Asia/Jakarta'))
                    ->where('status', '1');
            }))
            ->withCount(array('dvitem as tonase' => function ($query) {
                return $query->select(DB::raw('sum(new_tonase)'))
                    ->whereDay('date_time', Carbon::now('d')->timezone('Asia/Jakarta'))
                    ->where('status', '1');
            }))
            ->where('user_id', Auth::id())
            ->get();

        //items this day
        $dayItem = Dvitem::where('user_id', Auth::id())
            ->whereDay('date_time', Carbon::now('d')->timezone('Asia/Jakarta'))
            ->where('status', '1')
            ->get();

        // preg_match_all('!\d+!', $string, $matches);
        // print_r($matches);

        $weeklydata = DB::table('buyers')
            ->join('dvitems', 'buyers.id', '=', 'dvitems.buyer_id')
            ->whereBetween('dvitems.date_time', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->get();

        // get additional item in year
        $items =  Bookkeeping_journal::where('user_id', Auth::id())
            ->whereYear('date', Carbon::now('y')->timezone('Asia/Jakarta'))
            ->orderBy('date', 'ASC')
            ->get();

        return view('users.dashboard.index', [
            'yprofit' => $yprofit,
            'price' => $seller,
            'dvitems' => $dvitems,
            'deliveryItem' => $deliveryItem,
            'debt' => $debt,
            'mprofit' => $mprofit,
            'additionaltem' => $additionaltem,
            'yadditionaltem' => $yadditionaltem,
            'dprofit' => $dprofit,
            'weeklydata' => $weeklydata,
            'dayItem' => $dayItem,
            'goldprice' => $goldprice,
            'items' => $items,
            'hijri_mont' => $hijri_mont,
            'hijri_year'=> $hijri_year,
            'hijri_mont_created_at' => $user_hijri_month,
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
