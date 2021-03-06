<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Dvitem;
use App\Graded_Item;
use App\Note;
use App\Item;
use Auth;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $item_id = $request->get('item_id');
        $note = new Note;
        $note->price = $request->get('price_total');
        $note->tonase = $request->get('tonase_total');
        $note->save();
        $note_id = Note::latest('id')->where('user_id', Auth::id())->first();
        $item = Item::whereIn('id', $item_id)->update(['note_id' => $note->id]);
        return redirect()->route('pembelian.show', $request->get('seller_id'));
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
    public function buyerStore(Request $request)
    {
        $item_id = $request->get('item_id');
        $note = new Note;
        $note->price = $request->get('price_total');
        $note->tonase = $request->get('tonase_total');
        $note->user_id = Auth::id();
        $note->save();
        $note_id = Note::latest('id')->where('user_id', Auth::id())->first();
        $item = Graded_Item::whereIn('id', $item_id)->update(['note_id' => $note->id]);
        return redirect()->route('penjualan.show', $request->get('buyer_id'));
    }
}
