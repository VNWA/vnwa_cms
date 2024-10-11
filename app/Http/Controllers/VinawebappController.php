<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class VinawebappController extends Controller
{
    function changeStatus(Request $request)
    {
        DB::table($request->tb)
        ->where('id', $request->id)
        ->update(['is_show' => DB::raw('IF(is_show = 1, 0, 1)')]);
        return response()->json('Oke');
    }
    function changeHighlight(Request $request)
    {
        DB::table($request->tb)
            ->where('id', $request->id)
            ->update(['highlight' => $request->highlight]);
        return response()->json('Oke');
    }


    function changeORD(Request $request)
    {
        DB::table($request->tb)
            ->where('id', $request->id)
            ->update(['ord' => $request->value]);
        return response()->json('Update ORD Success');
    }


}
