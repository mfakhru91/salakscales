<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Item;
use App\Seller;
use App\Dvitem;
use App\Buyer;
use App\JournalLedger;
use App\Graded_Item;
use Auth;

class BarangController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $user = Auth::id();
    $items = Item::where('delivery', '0')->get();
    $sellers = Seller::with(array('item' => function ($query) {
      $query->where('payment', 'paid off')
        ->where('delivery', '0');
    }))
      ->where('user_id', Auth::id())
      ->get();
    $dvitems = Item::where('delivery', '1')->get();
    $dvsellers = Seller::with(array('item' => function ($query) {
      $query->where('payment', 'paid off')
        ->where('delivery', '1');
    }))
      ->where('user_id', Auth::id())
      ->get();

    $dvitems_data = Dvitem::where('user_id',Auth::id())->orderBy('status','asc')->get();
    return view('users.barang.index', [
      'items' => $items,
      'sellers' => $sellers,
      'dvitems' => $dvitems,
      'dvsellers' => $dvsellers,
      'user' => $user,
      'dvitems_data' => $dvitems_data
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
    $seller_id = $request->get('seller_id');

    $this->validate($request, [
      'seller_id' => 'required',
      'tonase' => 'required|integer',
      'price' => 'required',
      'payment' => 'required',
    ]);
    $item = new Item;
    $item->seller_id = $request->get('seller_id');
    $item->tonase = $request->get('tonase');
    $item->price = $request->get('price');
    $item->payment = $request->get('payment');
    $item->status = 'process';
    $item->save();

    $sellers = Seller::findOrFail($seller_id);

    $JournalLedger = new JournalLedger;
    $JournalLedger->user_id = Auth::id();
    $JournalLedger->description = "Pembelian Salak Ke " . $sellers->name;
    $JournalLedger->status = "kredit";
    $JournalLedger->nominal = $request->get('price');
    $JournalLedger->item_id = $item->id;
    $JournalLedger->date = Carbon::now()->timezone('Asia/Jakarta')->format('Y-m-d');
    $JournalLedger->save();

    return redirect()->route('barang.index', $seller_id)->with('status', 'Barang berhasil ditambah');
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
    $user = Auth::id();
    $item = Item::findOrFail($id);
    return view('users.barang.edit', [
      'item' => $item,
      'user' => $user
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
    $item = Item::findOrFail($id);
    $item->tonase = $request->get('tonase');
    $item->price = $request->get('price');
    $item->payment = $request->get('payment');
    $item->seller_id = $request->get('seller_id');
    $item->status = $request->get('status');
    $item->save();

    $JournalLedger = JournalLedger::where('item_id', $id)->first();
    $JournalLedger->status = "kredit";
    $JournalLedger->nominal = $request->get('price');
    $JournalLedger->date = Carbon::now()->timezone('Asia/Jakarta')->format('Y-m-d');
    $JournalLedger->save();

    $seller_id = $request->get('seller_id');
    return redirect()->route('pembelian.show', $seller_id)->with('status', 'barang berhasil diperbarui');
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
    $JournalLedger = JournalLedger::where('item_id', $id)->first();
    $JournalLedger->delete();
    $items = Item::findOrFail($id);
    $items->delete();
    return redirect()->route('barang.index')->with('status', '1 barang berhasil dihapus');
  }
  public function printSeller(Request $request)
  {
    $this->validate($request, [
      'item' => 'required'
    ]);
    $seller = Seller::findOrFail($request->get('saller_id'));
    $item = $request->get('item');
    $items = Item::find($item);
    $note_id = null;
    return view('users.barang.print', [
      'items' => $items,
      'seller' => $seller,
      'note_id' => $note_id
    ]);
  }
  public function printBuyer(Request $request)
  {
    $this->validate($request, [
      'item' => 'required'
    ]);
    $buyer = Buyer::findOrFail($request->get('buyer_id'));
    $item = $request->get('item');
    $dvitems = Graded_Item::find($item);
    $note_id = null;
    return view('users.barang.byprint', [
      'items' => $dvitems,
      'buyer' => $buyer,
      'note_id' => $note_id
    ]);
  }
  public function delivery(Request $request)
  {
    // get data delivered item
    $dvitem = Dvitem::select('new_tonase', 'old_tonase')
      ->orderBy('date_time', 'ASC')
      ->limit(1)
      ->where('user_id', Auth::id())
      ->get();

    // check if delivered tabel is empty
    if ($dvitem->isEmpty()) {
      $item_id = $request->get('item');

      // get items id
      $items = Item::whereIn('id', $item_id)->get();

      // get sum tonase data
      $tonase = DB::table('items')
        ->whereIn('id', $item_id)
        ->sum('tonase');

      return view('users.dvbarang.index', [
        'items' => $items,
        'tonase' => $tonase,
        'item_id' => $item_id,
      ]);
    } else {
      if ($dvitem[0]->old_tonase == 0) {
        $item_id = $request->get('item');
        $items = Item::whereIn('id', $item_id)->get();
        $price = DB::table('items')
          ->whereIn('id', $item_id)
          ->sum('price');
        $tonase = DB::table('items')
          ->whereIn('id', $item_id)
          ->sum('tonase');
        return view('users.dvbarang.index', [
          'items' => $items,
          'price' => $price,
          'tonase' => $tonase,
          'item_id' => $item_id,
        ]);
      } else {
        return redirect()->route('barang.index')->with('status', 'barang belum habis tolong selesaikan transaksi terlebih dahulu');
      }
    }
  }
  public function dvitem(Request $request)
  {
    $items_id = $request->get('items_id');
    $item = Item::whereIn('id', $items_id)
      ->update([
        'delivery' => '1',
        'status' => 'sold'
      ]);
    $date = Carbon::now()->format('Y-m-d');
    $item = new Dvitem;
    $item->user_id = Auth::id();
    $item->new_tonase = $request->get('tonase');
    $item->date_time = $date;
    $item->save();
    return redirect()->route('barang.index')->with('status', 'barang terconfirmasi');
  }
}
