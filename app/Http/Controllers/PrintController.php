<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use App\Seller;
class PrintController extends Controller
{
    public function noteBarang(Request $request)
    {
    	$note_id = $request->get('note');
    	$seller = Seller::findOrFail($request->get('saller_id'));
    	$items= Item::where('note_id',$note_id)->get();
      	return view('users.barang.print',[
        	'items'=>$items,
        	'seller'=>$seller,
      	]);

    }
}
