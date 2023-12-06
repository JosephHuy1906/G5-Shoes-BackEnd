<?php

namespace App\Http\Controllers;

use App\Models\BillDetail;
use App\Models\Product;
use App\Models\Bill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BillDetailController extends Controller
{
    public function store(Request $request)
    {
        $jsonData = $request->json()->all();

        $validator = Validator::make($jsonData, [
            '*.billID' => 'required|exists:bills,id',
            '*.productID' => 'required|exists:products,id',
            '*.sizeID' => 'required', // Cần kiểm tra và chỉnh sửa nếu có
            '*.userID' => 'required',
            '*.price' => 'required',
            '*.quantity' => 'required'
        ]);

        if ($validator->fails()) {
            $arr = [
                'status' => 404,
                'success' => false,
                'message' => 'Lỗi kiểm tra dữ liệu',
                'data' => $validator->errors()
            ];
            return response()->json($arr, 404);
        }

        foreach ($jsonData as $input) {
            // Kiểm tra sự tồn tại của sản phẩm và hóa đơn
            $product = Product::find($input['productID']);
            $bill = Bill::find($input['billID']);

            if (!$product || !$bill) {
                $arr = [
                    'status' => 404,
                    'success' => false,
                    'message' => 'Sản phẩm hoặc hóa đơn không tồn tại',
                ];
                return response()->json($arr, 404);
            }

            // Chỉnh sửa 'sizeID' nếu cần thiết
            // ...

            // Thêm chi tiết hóa đơn
            BillDetail::create([
                'billID' => $input['billID'],
                'productID' => $input['productID'],
                'sizeID' => $input['sizeID'],
                'userID' => $input['userID'],
                'price' => $input['price'],
                'quantity' => $input['quantity'],
            ]);
        }

        $arr = [
            'status' => 201,
            'success' => true,
            'message' => "Bill detail đã được thêm",
        ];

        return response()->json($arr, 201);
    }
}
