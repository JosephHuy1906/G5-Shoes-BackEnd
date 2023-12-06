<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Builder;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return $this->successResponse("List product", \App\Http\Resources\Product::collection($products));
    }

    public function create()
    {
        $products = Product::orderBy('id', 'desc')->take(4)->get();
        return $this->successResponse("List 4 product new", \App\Http\Resources\Product::collection($products));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
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
            return $this->errorResponse('Input value error', $validator->errors(), 400);
        }

        $product = Product::create($request->all());
        return $this->successResponse("Create Product successfully", new \App\Http\Resources\Product($product), 201);
    }

    public function show(string $id)
    {
        $product = Product::find($id);

        if (is_null($product)) {
            return $this->errorResponse('Product does not exist', null, 404);
        }

        return $this->successResponse("Detail Product", new \App\Http\Resources\Product($product));
    }

    public function edit(int $id)
    {
        $randomProducts = Product::inRandomOrder()->take($id)->get();
        return $this->successResponse("List $id product random", \App\Http\Resources\Product::collection($randomProducts));
    }

    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Input error value', $validator->errors(), 400);
        }

        $product->update($request->only(['name', 'price']));
        return $this->successResponse('Product update successfully', new \App\Http\Resources\Product($product));
    }

    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return $this->errorResponse('Product does not exist', null, 404);
        }

        $product->delete();

        return $this->successResponse('Product delete successfully');
    }

    public function search(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'keyword' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Input value error', $validator->errors(), 400);
        }

        $keyword = $request->input('keyword');
        $products = Product::where('name', 'like', '%' . $keyword . '%')->get();

        return $this->successResponse("Search results for '$keyword'", \App\Http\Resources\Product::collection($products));
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
