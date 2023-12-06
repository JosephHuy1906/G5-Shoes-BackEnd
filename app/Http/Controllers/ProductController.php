<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $arr = [
            'status' => true,
            'message' => "List product",
            'data' => \App\Http\Resources\Product::collection($products)
        ];
        return response()->json($arr, 200);
    }

    public function create()
    {
        $products = Product::latest()->take(4)->get();
        $arr = [
            'status' => true,
            'message' => "List 4 product new",
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
                'message' => 'Input value error',
                'data' => $validator->errors()
            ];
            return response()->json($arr, 200);
        }
        $product = Product::create($input);
        $arr = [
            'status' => true,
            'message' => "Create Product successfuly",
            'data' => new \App\Http\Resources\Product($product)
        ];
        return response()->json($arr, 201);
    }


    public function show(string $id)
    {
        $product = Product::find($id);
        if (is_null($product)) {
            $arr = [
                'success' => false,
                'message' => 'Product does not exits',
                'dara' => []
            ];
            return response()->json($arr, 200);
        }
        $arr = [
            'status' => true,
            'message' => "Detail Product",
            'data' => new \App\Http\Resources\Product($product)
        ];
        return response()->json($arr, 201);
    }


    public function edit(int $id)
    {
        $randomProducts = Product::inRandomOrder()->take($id)->get();

        $arr = [
            'status' => true,
            'message' => "List $id product ramdom",
            'data' => \App\Http\Resources\Product::collection($randomProducts)
        ];

        return response()->json($arr, 200);
    }

    public function update(Request $request, Product $product)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'price' => 'required'
        ]);
        if ($validator->fails()) {
            $arr = [
                'success' => false,
                'message' => 'Input error value',
                'data' => $validator->errors()
            ];
            return response()->json($arr, 200);
        }
        $product->name = $input['name'];
        $product->price = $input['price'];
        $product->save();
        $arr = [
            'status' => true,
            'message' => 'Product update successfuly',
            'data' => new \App\Http\Resources\Product($product)
        ];
        return response()->json($arr, 200);
    }

    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            $arr = [
                'status' => 404,
                'success' => false,
                'message' => 'Product does not exist ',
            ];
            return response()->json($arr, 404);
        }

        $product->delete();

        $arr = [
            'status' => 200,
            'success' => true,
            'message' => 'Product delete successfully',
        ];

        return response()->json($arr, 200);
    }
}
