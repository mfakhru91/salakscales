<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use App\Seller;
use App\Item;
use Auth;

class PembelianController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $seller = Seller::with(array('item' => function ($query) {
      return $query->where('payment', '=', 'paid off');
    }))
      ->where('user_id', Auth::id())
      ->get();
    return view('users.pembelian.index', [
      'seller' => $seller,
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
      'address' => 'required',
      'no_telp' => 'required|numeric',
    ]);
    $new_seller = new Seller;
    $new_seller->user_id = Auth::id();
    $new_seller->name = $request->get('name');
    $new_seller->address = $request->get('address');
    $new_seller->no_telp = $request->get('no_telp');
    $new_seller->save();

    return redirect()->route('pembelian.index');
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
    $seller = Seller::findOrFail($id);
    $paidOff = Seller::with(array('item' => function ($query) {
      $query->where('payment', 'paid off');
    }))->find($id);
    return view('users.pembelian.show', [
      'seller' => $seller,
      'paidOff' => $paidOff,
      'user' => $user,
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
    $seller = Seller::findOrFail($id);
    return view('users.pembelian.edit', [
      'seller' => $seller,
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
      'address' => 'required',
      'no_telp' => 'required',
    ]);
    $update = Seller::findOrFail($id);
    $update->user_id = Auth::user()->id;
    $update->name = $request->get('name');
    $update->address = $request->get('address');
    $update->no_telp = $request->get('no_telp');
    $update->save();
    return redirect()->route('pembelian.show', $id)->with('status', 'data pembeli berhasil diperbarui');
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
    $seller = Seller::findOrFail($id);
    $seller->delete();
    return redirect()->route('pembelian.index')->with('status', $seller->name . ' berhasil dihapus');
  }
  public function addItems(Request $request)
  {
    $this->validate($request, [
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
    $seller_id = $request->get('seller_id');
    return redirect()->route('pembelian.show', $seller_id)->with('status', 'Barang berhasil ditambah');
  }
  public function deleteItem($id)
  {
    $items = Item::findOrFail($id);
    $items->delete();
    return redirect()->route('pembelian.show', $items->seller_id)->with('status', '1 barang berhasil dihapus');
  }
}
