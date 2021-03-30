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
use App\Zakat;
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
        $user_hijri_year = \GeniusTS\HijriDate\Hijri::convertToHijri($user_date_formate)->format('Y');
        $user_hijri_month = \GeniusTS\HijriDate\Hijri::convertToHijri($user_date_formate)->format('m');
        $user_hijri_day = \GeniusTS\HijriDate\Hijri::convertToHijri($user_date_formate)->format('d');

        $last_month = '0' . ($user_hijri_month - 1);
        $year_hijri_start = \GeniusTS\HijriDate\Hijri::convertToGregorian($user_hijri_day, $user_hijri_month, $user_hijri_year);
        $year_hijri_end = \GeniusTS\HijriDate\Hijri::convertToGregorian($hijri_day, $last_month, $hijri_year + 1);
        
        // gold scraping
        $connected = @fsockopen("www.logammulia.com", 80); //website, port  (try 80 or 443)
        if ($connected){
            $client = new Client();
            $page = $client->request('GET', 'https://www.logammulia.com/id');
            $response = $client->getInternalResponse();
            if ($response->getStatusCode() == 200) {
                $page->filter('.current')->each(function ($item) {
                    array_push($this->states, $item->text());
                });
                preg_match_all('!\d+!', $this->states[0], $matches);
        
                $goldprice = $matches[0][0] . $matches[0][1];
                $connection = 'internet_access';
            }else{
                $goldprice = null;
                $connection = 'internet_access';
            }
        }else{
            $goldprice = null;
            $connection = 'no_internet_access';
        }
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
        $priceyear  = Seller::withCount(array('item as total_price' => function ($query) use ($year_hijri_converter) {
            return $query->select(DB::raw('sum(price)'))
                ->where('status', 'sold')
                ->whereYear('created_at', $year_hijri_converter);
        }))
            ->where('user_id', Auth::id())
            ->get();

        //get delivered item
        $dvitems = Buyer::withCount('graded_item_delivery as dvcounting')->where('user_id', Auth::id())->get();

        // all items
        $deliveryItem = Buyer::withCount('graded_item as dvitem')
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
        $yprofit = Buyer::withCount(array('graded_item as price' => function ($query) use ($year_hijri_start, $year_hijri_end) {
            return $query->select(DB::raw('sum(price)'))
                ->whereBetween('date_time', [$year_hijri_start, $year_hijri_end])
                ->where('status', '1');
        }))
            ->withCount(array('graded_item as income' => function ($query) use ($year_hijri_start, $year_hijri_end) {
                return $query->select(DB::raw('sum(income)'))
                    ->whereBetween('date_time', [$year_hijri_start, $year_hijri_end])
                    ->where('status', '1');
            }))
            ->withCount(array('graded_item as tonase' => function ($query) use ($year_hijri_start, $year_hijri_end) {
                return $query->select(DB::raw('sum(new_tonase)'))
                    ->whereBetween('date_time', [$year_hijri_start, $year_hijri_end])
                    ->where('status', '1');
            }))
            ->where('user_id', Auth::id())
            ->get();

        // income this year
        $yprofit_gregorian = Buyer::withCount(array('graded_item as price' => function ($query){
            return $query->select(DB::raw('sum(price)'))
                ->whereYear('created_at', Carbon::now('Y')->timezone('Asia/Jakarta'))
                ->where('status', '1');
        }))
            ->withCount(array('graded_item as income' => function ($query){
                return $query->select(DB::raw('sum(income)'))
                    ->whereYear('created_at', Carbon::now('Y')->timezone('Asia/Jakarta'))
                    ->where('status', '1');
            }))
            ->withCount(array('graded_item as tonase' => function ($query){
                return $query->select(DB::raw('sum(new_tonase)'))
                    ->whereYear('created_at', Carbon::now('Y')->timezone('Asia/Jakarta'))
                    ->where('status', '1');
            }))
            ->where('user_id', Auth::id())
            ->get();

        $yadditionaltem =  Bookkeeping_journal::where('user_id', Auth::id())
            ->whereMonth('date', Carbon::now('m')->timezone('Asia/Jakarta'))
            ->get();

        // income this month
        $mprofit = Buyer::withCount(array('graded_item as price' => function ($query) {
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

        $additionaltem =  Bookkeeping_journal::where('user_id', Auth::id())
            ->whereMonth('date', Carbon::now('m')->timezone('Asia/Jakarta'))
            ->get();

        // income this day
        $dprofit = Buyer::withCount(array('graded_item as price' => function ($query) {
            return $query->select(DB::raw('sum(price)'))
                ->whereDay('date_time', Carbon::now('d')->timezone('Asia/Jakarta'))
                ->where('status', '1');
        }))
            ->withCount(array('graded_item as income' => function ($query) {
                return $query->select(DB::raw('sum(income)'))
                    ->whereDay('date_time', Carbon::now('d')->timezone('Asia/Jakarta'))
                    ->where('status', '1');
            }))
            ->withCount(array('graded_item as tonase' => function ($query) {
                return $query->select(DB::raw('sum(new_tonase)'))
                    ->whereDay('date_time', Carbon::now('d')->timezone('Asia/Jakarta'))
                    ->where('status', '1');
            }))
            ->where('user_id', Auth::id())
            ->get();

        //items this day
        $dayItem = Dvitem::where('user_id', Auth::id())
            ->whereDay('created_at', Carbon::now('d')->timezone('Asia/Jakarta'))
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
        // get additional item in hijri year
        $hijri_items =  Bookkeeping_journal::where('user_id', Auth::id())
            ->whereBetween('date', [$year_hijri_start, $year_hijri_end])
            ->orderBy('date', 'ASC')
            ->get();
        
        // get zakat

        $zakat = Zakat::where('user_id', Auth::id())->first();
        if (empty($zakat)) {
            $newzakat = new Zakat;
            $newzakat->user_id = Auth::id();
            $newzakat->save();
        }

        $hijri_haul = $zakat->start_haul;
        $hijri_haul_year = \GeniusTS\HijriDate\Hijri::convertToHijri($hijri_haul)->format('Y');
        $hijri_haul_month = \GeniusTS\HijriDate\Hijri::convertToHijri($hijri_haul)->format('m');
        $hijri_haul_day = \GeniusTS\HijriDate\Hijri::convertToHijri($hijri_haul)->format('d');
        return view('users.dashboard.index', [
            'connection'=> $connection,
            'yprofit' => $yprofit,
            'yprofit_gregorian' => $yprofit_gregorian,
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
            'hijri_items' => $hijri_items,
            'hijri_mont' => $hijri_mont,
            'hijri_year' => $hijri_year,
            'hijri_mont_created_at' => $user_hijri_month,
            'zakatcheck' => $zakat,
            'hijri_haul_year' => $hijri_haul_year,
            'hijri_haul_month' => $hijri_haul_month,
            'hijri_haul_day' => $hijri_haul_day,
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
