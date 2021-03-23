<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Zakat;

class ZakatApiController extends Controller
{
    public function update(Request $request, $id)
    {
        $zakat = Zakat::where('user_id', $id)->first();
        if (empty($zakat->start_haul)) {
            $zakat->start_haul = $request->get('start_haul');
            $zakat->nishab = $request->get('nishab');
            $zakat->save();
            return response()->json([
                'code' => '200',
                'zakat' => $zakat,
            ]);
        }else{
            return response()->json([
                'code' => '200',
                'zakat' => 'zakat table has been updated',
            ]);
        }
    }

    public function haulupdate($id)
    {
        $zakat = Zakat::where('user_id', $id)->first();
        $zakat->start_haul = null;
        $zakat->nishab = null;
        $zakat->save();
        return response()->json([
            'code' => '200',
            'zakat' => 'haul tidak terpenuhi',
        ]);

    }
}
