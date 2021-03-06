<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Buyer;
use App\Dvitem;
use App\Graded_Item;
use App\Grading;
use App\JournalLedger;
use Auth;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $buyers = Buyer::where('user_id', Auth::id())->paginate(15);
        return view('users.penjualan.index', [
            'buyers' => $buyers,
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
        $this->validate($request, [
            'name' => 'required|min:5',
            'market' => 'required',
            'address' => 'required',
            'no_telp' => 'required|numeric',
        ]);
        $new_buyers = new Buyer;
        $new_buyers->user_id = Auth::id();
        $new_buyers->market = $request->get('market');
        $new_buyers->name = $request->get('name');
        $new_buyers->address = $request->get('address');
        $new_buyers->no_telp = $request->get('no_telp');
        $new_buyers->save();

        return redirect()->route('penjualan.index')->with('status', 'data penjualan baru telah ditambah');;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Auth::id();

        // get one row of delivered data
        $itemDelivered = Graded_Item::orderBy('id', 'DESC')->take(1)
            ->where('user_id', $user)
            ->first();

        // check old tonase data
        if ($itemDelivered->old_tonase == null) {
            $data = Graded_Item::Select('user_id', 'buyer_Id', 'date_time', 'new_tonase as tonase',)
                ->orderBy('id', 'DESC')->take(1)
                ->where('user_id', $user)
                ->first();
        } else {
            $data = Graded_Item::Select('user_id', 'buyer_Id', 'date_time', 'old_tonase as tonase',)
                ->orderBy('id', 'DESC')->take(1)
                ->where('user_id', $user)
                ->first();
        }

        //get delivery item evry Year
        $YearItem = Graded_Item::where('user_id', Auth::id())
            ->where('status', '1')
            ->whereYear('date_time', Carbon::now('y')->timezone('Asia/Jakarta'))
            ->where('buyer_id', $id)
            ->get();

        //get delivery item evry month
        $MonthItem = Graded_Item::where('user_id', Auth::id())
            ->where('status', '1')
            ->whereMonth('date_time', Carbon::now('m')->timezone('Asia/Jakarta'))
            ->where('buyer_id', $id)
            ->get();

        //get delivery item evry day
        $DayItem = Graded_Item::where('user_id', Auth::id())
            ->where('status', '1')
            ->whereDay('date_time', Carbon::now('d')->timezone('Asia/Jakarta'))
            ->where('buyer_id', $id)
            ->get();
        // get buyyer id
        $buyyers = Buyer::where('id', $id)->first();

        // get buyyer delivered item
        $buyyerDevItem = Graded_Item::where('user_id', $user)
            ->where('buyer_id', $id)
            ->orderBy('status', 'asc')
            ->get();
        //grade 
        $grading = Grading::where('buyer_id', $id)->get();
        return view('users.penjualan.show', [
            'buyyers' => $buyyers,
            'user' => $user,
            'dvitem' => $data,
            'monthItem' => $MonthItem,
            'yearItem' => $YearItem,
            'dayItem' => $DayItem,
            'buyyerItem' => $buyyerDevItem,
            'grading' => $grading,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $buyer = Buyer::findOrFail($id);
        return view('users.penjualan.edit', [
            'buyer' => $buyer,
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
            'name' => 'required|min:5',
            'market' => 'required',
            'address' => 'required',
            'no_telp' => 'required|numeric',
            'tools' => 'nullable|numeric',
            'packing' => 'nullable|numeric',
            'shipping_charges' => 'numeric',
            'selling_price' => 'numeric',
        ]);
        $update = Buyer::findOrFail($id);
        $update->user_id = Auth::user()->id;
        $update->name = $request->get('name');
        $update->market = $request->get('market');
        $update->address = $request->get('address');
        $update->no_telp = $request->get('no_telp');
        $update->tools = $request->get('tools');
        $update->packing = $request->get('packing');
        $update->shipping_charges = $request->get('shipping_charges');
        $update->selling_price = $request->get('selling_price');
        $update->save();
        return redirect()->route('penjualan.show', $id)->with('status', 'data pembeli berhasil diperbarui');
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

    public function delete($id)
    {
        $buyer = Buyer::findOrFail($id);
        $buyer->delete();
        return redirect()->route('penjualan.index')->with('status', $buyer->name . ' berhasil dihapus');
    }

    public function addItems(Request $request)
    {
        list($price,$grading_id) = explode('|', $_POST['grading']);
        $date = Carbon::now()->format('Y-m-d');
        $addNewItem = new Graded_Item;
        $addNewItem->user_id = Auth::id();
        $addNewItem->buyer_id =  $request->get('buyyer_id');
        $addNewItem->date_time = $date;
        $addNewItem->new_tonase = $request->get('new_tonase');
        $addNewItem->old_tonase = $request->get('old_tonase');
        $addNewItem->price = $request->get('price');
        $addNewItem->grading_id = $grading_id;
        $addNewItem->save();

        return redirect()->route('penjualan.show', $request->get('buyyer_id'))->with('status', 'berhasil menambahkan pengiriman baranh');
    }
    public function income(Request $request)
    {
        $buyer_id = $request->get('id');
        $buyer = Buyer::findOrFail($buyer_id);
        $buyer->yincome = $request->get('yincome');
        $buyer->mincome = $request->get('mincome');
        $buyer->dincome = $request->get('dincome');
        $buyer->save();
        return redirect()->route('penjualan.show', $buyer_id)->with('status', 'berhasil memperbarui keuntungan bulan ini');
    }
}
