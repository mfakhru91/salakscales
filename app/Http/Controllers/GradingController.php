<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Buyer;
use App\Dvitem;
use App\Graded_Item;
use App\Grading;
use Carbon\Carbon;
use Auth;

class GradingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gradings =  Grading::get();
        $buyers = Buyer::where('user_id', Auth::id())->paginate(15);
        return view('users.grading.index', [
            'buyers' => $buyers,
            'gradings' => $gradings,
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
            'grade_name' => 'required',
            'price' => 'required|numeric',
        ]);
        $add_grading = new Grading;
        $add_grading->name = $request->get('grade_name');
        $add_grading->price = $request->get('price');
        $add_grading->buyer_id = $request->get('buyer_id');
        $add_grading->save();
        return redirect()->route('grading.show', $request->get('buyer_id'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $gradings = Grading::where('buyer_id', $id)->get();
        $buyer_id = $id;
        return view('users.grading.show', [
            'gradings' => $gradings,
            'buyer_id' => $buyer_id,
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
        $grading = Grading::findOrFail($id);
        return view('users.grading.edit', [
            'grading' => $grading
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
            'grade_name' => 'required',
            'price' => 'required|numeric',
        ]);
        $grading = Grading::findOrFail($id);
        $grading->name = $request->get('grade_name');
        $grading->price = $request->get('price');
        $grading->save();
        return redirect()->route('grading.show', $grading->buyer_id);
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
        $grading = Grading::findOrFail($id);
        $grading->delete();
        return redirect()->route('grading.show', $grading->buyer_id);
    }

    public function confirmation_grade(Request $request)
    {
        $graded_items = Dvitem::whereIn('id', $request->get('graded_item'))->get();
        return view('users.graded_item.index', [
            'graded_items' => $graded_items,
        ]);
    }
    public function graded_store_item(Request $request)
    {
        $dvitem = Graded_Item::select('new_tonase', 'old_tonase')
            ->orderBy('created_at', 'DESC')
            ->limit(1)
            ->where('user_id', Auth::id())
            ->first();
        if (empty($dvitem->new_tonase)) {
            $date = Carbon::now()->format('Y-m-d');
            $dvitem = Dvitem::whereIn('id', $request->get('id'))
                ->update([
                    'status' => '1',
                ]);
            $item = new Graded_Item();
            $item->user_id = Auth::id();
            $item->new_tonase = $request->get('tonase');
            $item->date_time = $date;
            $item->save();
            return redirect()->route('barang.index');
        } else {
            return redirect()->route('barang.index')->with('danger', 'brang masih tersedia harap menyelesaikan penjualan');
        }
    }

    public function grade_item_edit($id)
    {
        $grade_item = Dvitem::findOrFail($id);
        return view('users.graded_item.edit', [
            'grading_item' => $grade_item,
        ]);
    }

    public function grade_item_update(Request $request, $id)
    {
        $this->validate($request, [
            'graded_tonase' => 'required'
        ]);
        $grade_item = Dvitem::findOrFail($id);
        $grade_item->graded_tonase = $request->get('graded_tonase');
        $grade_item->save();

        return redirect()->route('barang.index');
    }

    public function grade_item_delete($id)
    {
        $grade_item = Dvitem::findOrFail($id);
        $grade_item->delete();
        return redirect()->route('barang.index');
    }
}
