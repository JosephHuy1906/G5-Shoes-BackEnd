<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Oder;
use App\Models\OderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OderDetailController extends Controller
{
    public function store(Request $request)
    {
        $jsonData = $request->json()->all();

        $validator = Validator::make($jsonData, [
            '*.oderID' => 'required|exists:oders,id',
            '*.productID' => 'required|exists:products,id',
            '*.size' => 'required', 
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
            $oder = Oder::find($input['oderID']);

            if (!$product || !$oder) {
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
            OderDetail::create([
                'oderID' => $input['oderID'],
                'productID' => $input['productID'],
                'size' => $input['size'],
                'price' => $input['price'],
                'quantity' => $input['quantity'],
            ]);
        }

        $arr = [
            'status' => 201,
            'success' => true,
            'message' => "Oder detail đã được thêm",
        ];

        return response()->json($arr, 201);
    }
    public function show(string $id)
    {
        $oderDetail = OderDetail::where('oderID', $id)->get();
        if ($oderDetail->isEmpty()) {
            return $this->errorResponse("No oder found in oder detail with ID $id", null, 404);
        }
        return $this->successResponse("List oder detail by oder", \App\Http\Resources\OderDetail::collection($oderDetail));
    }

    private function successResponse($message, $data = null, $status = 200)
    {
        return response()->json(['status' => true, 'message' => $message, 'data' => $data], $status);
    }

    private function errorResponse($message, $data = null, $status = 404)
    {
        return response()->json(['status' => false, 'message' => $message, 'data' => $data], $status);
    }
}
