<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use App\Seller;
use App\Buyer;
use App\Dvitem;

class PrintController extends Controller
{
	public function noteBarang(Request $request)
	{
		if ($request->get('note') == null) {
			$note_id = null;
		}else {
			$note_id = $request->get('note');
		}
		$seller = Seller::findOrFail($request->get('saller_id'));
		$items = Item::where('note_id', $note_id)->get();
		return view('users.barang.print', [
			'items' => $items,
			'seller' => $seller,
			'note_id' => $note_id
		]);
	}
	public function noteBuyer(Request $request)
	{
		if ($request->get('note') == null) {
			$note_id = null;
		}else {
			$note_id = $request->get('note');
		}
		$buyer = Buyer::findOrFail($request->get('buyer_id'));
		$items = Dvitem::where('note_id', $note_id)->get();
		return view('users.barang.byprint', [
			'items' => $items,
			'buyer' => $buyer,
			'note_id'=>$note_id,
		]);
	}
}
