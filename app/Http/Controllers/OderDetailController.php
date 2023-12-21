<?php

namespace App\Http\Controllers;

use App\Http\Resources\OderDetail as ResourcesOderDetail;
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

            return $this->errorResponse('Lỗi kiểm tra dữ liệu', $validator->errors(), 404);
        }

        foreach ($jsonData as $input) {
            $product = Product::find($input['productID']);
            $oder = Oder::find($input['oderID']);

            if (!$product || !$oder) {

                return $this->errorResponse('Sản phẩm hoặc hóa đơn không tồn tại', 404);
            }
            $oderDT =  OderDetail::create([
                'oderID' => $input['oderID'],
                'productID' => $input['productID'],
                'size' => $input['size'],
                'price' => $input['price'],
                'quantity' => $input['quantity'],
            ]);
        }

        return $this->successResponse('Oder detail đã được thêm', new ResourcesOderDetail($oderDT));
    }
    public function show(string $id)
    {
        $oderDetail = OderDetail::where('oderID', $id)->get();
        if ($oderDetail->isEmpty()) {
            return $this->errorResponse("No oder found in oder detail with ID $id", null, 404);
        }
        return $this->successResponse("List oder detail by oder", ResourcesOderDetail::collection($oderDetail));
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
