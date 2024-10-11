<?php

namespace App\Http\Controllers;

use App\Models\ProductOrder;
use Illuminate\Http\Request;

class ProductOrderController extends Controller
{
    public function loadDataTable()
    {
        $orders = ProductOrder::latest()->get();
        return response()->json($orders, 200);
    }
    function delete(Request $request)
    {

        try {
            ProductOrder::whereIn('id', $request->dataId)->delete();
            return response()->json(['message' => 'Xóa dữ liệu thành công'], 200);
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
