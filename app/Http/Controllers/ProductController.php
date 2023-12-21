<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
            'img1' => 'required|image|mimes:png,jpg,jpeg,gif|max:2048',
            'img2' => 'required|image|mimes:png,jpg,jpeg,gif|max:2048',
            'img3' => 'required|image|mimes:png,jpg,jpeg,gif|max:2048',
            'img4' => 'required|image|mimes:png,jpg,jpeg,gif|max:2048',
            'newPrice' => 'required',
            'oldPrice' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Input value error', $validator->errors(), 400);
        }

        // Upload and store images
        $imagePaths = [];
        for ($i = 1; $i <= 4; $i++) {
            $imageKey = 'img' . $i;
            $image = $request->file($imageKey);

            $storagePath = 'images/products';
            $filename = time() . '_' . Str::random(10) . '_' . $image->getClientOriginalName();
            $image->storeAs($storagePath, $filename, 'public');

            $baseUrl = Config::get('app.url');
            $imagePaths[$imageKey] = $baseUrl . '/api/' . $storagePath . '/' . $filename;
        }

        // Create new product with image paths
        $productData = $request->except('img1', 'img2', 'img3', 'img4');
        $productData = array_merge($productData, $imagePaths);
        $product = Product::create($productData);

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
        $highestOldPriceProducts = Product::orderBy('oldPrice', 'desc')->take($id)->get();
        return $this->successResponse("List $id products with highest oldPrice", \App\Http\Resources\Product::collection($highestOldPriceProducts));
    }


    // public function update(Request $request, Product $product)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'name' => 'sometimes|required',
    //         'categoryID' => 'sometimes|required',
    //         'sizeID' => 'sometimes|required',
    //         'img1' => 'sometimes|image|mimes:png,jpg,jpeg,gif|max:2048',
    //         'img2' => 'sometimes|image|mimes:png,jpg,jpeg,gif|max:2048',
    //         'img3' => 'sometimes|image|mimes:png,jpg,jpeg,gif|max:2048',
    //         'img4' => 'sometimes|image|mimes:png,jpg,jpeg,gif|max:2048',
    //         'newPrice' => 'sometimes|required',
    //         'oldPrice' => 'sometimes|required',
    //         'description' => 'sometimes|required',
    //     ]);

    //     if ($validator->fails()) {
    //         return $this->errorResponse('Input error value', $validator->errors(), 400);
    //     }

    //     $data = $request->only([
    //         'name',
    //         'categoryID',
    //         'sizeID',
    //         'newPrice',
    //         'oldPrice',
    //         'description',
    //         'img1',
    //         'img2',
    //         'img3',
    //         'img4',
    //     ]);
    //     for ($i = 1; $i <= 4; $i++) {
    //         $imageKey = 'img' . $i;
    //         if ($request->has($imageKey)) {
    //             $oldImagePath = str_replace(url('/') . '/api/', '', $product->$imageKey);

    //             $image = $request->file($imageKey);
    //             $storagePath = 'images/products';
    //             $filename = time() . '_' . Str::random(10) . '_' . $image->getClientOriginalName();
    //             $image->storeAs($storagePath, $filename, 'public');
    //             if ($oldImagePath && Storage::disk('public')->exists($oldImagePath)) {
    //                 Storage::disk('public')->delete($oldImagePath);
    //             }

    //             $data[$imageKey] = Config::get('app.url') . '/api/' . $storagePath . '/' . $filename;
    //         }
    //     }
    //     if ($product->update($data)) {
    //         return $this->successResponse('Product update successfully', new \App\Http\Resources\Product($product));
    //     } else {
    //         return $this->errorResponse('Failed to update product', null, 500);
    //     }
    // }

    public function updateProductInfo(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required',
            'categoryID' => 'sometimes|required',
            'sizeID' => 'sometimes|required',
            'newPrice' => 'sometimes|required',
            'oldPrice' => 'sometimes|required',
            'description' => 'sometimes|required',
            'img1' => 'sometimes|image|mimes:png,jpg,jpeg,gif|max:2048',
            'img2' => 'sometimes|image|mimes:png,jpg,jpeg,gif|max:2048',
            'img3' => 'sometimes|image|mimes:png,jpg,jpeg,gif|max:2048',
            'img4' => 'sometimes|image|mimes:png,jpg,jpeg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Input error value', $validator->errors(), 400);
        }

        $data = $request->only([
            'name',
            'categoryID',
            'sizeID',
            'newPrice',
            'oldPrice',
            'description',
            'img1',
            'img2',
            'img3',
            'img4',
        ]);
        for ($i = 1; $i <= 4; $i++) {
            $imageKey = 'img' . $i;
            if ($request->has($imageKey)) {
                $oldImagePath = str_replace(url('/') . '/api/', '', $product->$imageKey);
                $image = $request->file($imageKey);
                $storagePath = 'images/products';
                $filename = time() . '_' . Str::random(10) . '_' . $image->getClientOriginalName();
                $image->storeAs($storagePath, $filename, 'public');
                if ($oldImagePath && Storage::disk('public')->exists($oldImagePath)) {
                    Storage::disk('public')->delete($oldImagePath);
                }
                $data[$imageKey] = Config::get('app.url') . '/api/' . $storagePath . '/' . $filename;
            }
        }
        if (!$product->update($data)) {
            return $this->errorResponse('Failed to update product information', null, 500);
        }
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

    public function getProductRamdom()
    {
        $randomProducts = Product::inRandomOrder()->take(4)->get();
        return $this->successResponse("List product random", \App\Http\Resources\Product::collection($randomProducts));
    }

    public function getProductPage(Request $request)
    {
        $page = $request->query('page', 1);
        $pageSize = $request->query('pageSize', 6);
        $products = Product::paginate($pageSize, ['*'], 'page', $page);
        return $this->successResponse("List product", \App\Http\Resources\Product::collection($products));
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
