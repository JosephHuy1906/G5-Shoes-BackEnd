<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $products = \App\Models\Product::all();
        $arr = [
            'status' => true,
            'message' => "Danh sách sản phẩm",
            'data' => \App\Http\Resources\Product::collection($products)
        ];
        return response()->json($arr, 200);
    }

    public function create()
    {
        $products = \App\Models\Product::latest()->take(4)->get();
        $arr = [
            'status' => true,
            'message' => "Danh sách 4 sản phẩm mới nhất",
            'data' => \App\Http\Resources\Product::collection($products)
        ];

        return response()->json($arr, 200);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'categoryID' => 'required',
            'sizeID' => 'required',
            'img1' => 'required',
            'img2' => 'required',
            'img3' => 'required',
            'img4' => 'required',
            'newPrice' => 'required',
            'oldPrice' => 'required',
            'description' => 'required',
        ]);
        if ($validator->fails()) {
            $arr = [
                'success' => false,
                'message' => 'Lỗi kiểm tra dữ liệu',
                'data' => $validator->errors()
            ];
            return response()->json($arr, 200);
        }
        $product = \App\Models\Product::create($input);
        $arr = [
            'status' => true,
            'message' => "Sản phẩm đã lưu thành công",
            'data' => new \App\Http\Resources\Product($product)
        ];
        return response()->json($arr, 201);
    }


    public function show(string $id)
    {
        $product = \App\Models\Product::find($id);
        if (is_null($product)) {
            $arr = [
                'success' => false,
                'message' => 'Không có sản phẩm này',
                'dara' => []
            ];
            return response()->json($arr, 200);
        }
        $arr = [
            'status' => true,
            'message' => "Chi tiết sản phẩm ",
            'data' => new \App\Http\Resources\Product($product)
        ];
        return response()->json($arr, 201);
    }


    public function edit(int $id)
    {
        $randomProducts = \App\Models\Product::inRandomOrder()->take($id)->get();

        $arr = [
            'status' => true,
            'message' => "Danh sách $id sản phẩm ngẫu nhiên",
            'data' => \App\Http\Resources\Product::collection($randomProducts)
        ];

        return response()->json($arr, 200);
    }

    public function update(Request $request, \App\Models\Product $product)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'price' => 'required'
        ]);
        if ($validator->fails()) {
            $arr = [
                'success' => false,
                'message' => 'Lỗi kiểm tra dữ liệu',
                'data' => $validator->errors()
            ];
            return response()->json($arr, 200);
        }
        $product->name = $input['name'];
        $product->price = $input['price'];
        $product->save();
        $arr = [
            'status' => true,
            'message' => 'Sản phẩm cập nhật thành công',
            'data' => new \App\Http\Resources\Product($product)
        ];
        return response()->json($arr, 200);
    }

    public function destroy(\App\Models\Product $product)
    {
        $product->delete();
        $arr = [
            'status' => true,
            'message' => 'Sản phẩm đã được xóa',
            'data' => [],
        ];
        return response()->json($arr, 200);
    }
}
