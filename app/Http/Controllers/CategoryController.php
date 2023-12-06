<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Resources\Category as CategoryResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        $category = Category::all();
        return $this->successResponse("List category", CategoryResource::collection($category));
    }



    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Input value error', $validator->errors(), 400);
        }

        $category = Category::create($request->all());
        return $this->successResponse("Create Category successfully", new CategoryResource($category), 201);
    }


    public function update(Request $request, Category $category)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Input error value', $validator->errors(), 400);
        }

        $data = $request->input();
        $category->update($data);
        return $this->successResponse('Category update successfully', new \App\Http\Resources\Category($category));
    }



    public function destroy($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return $this->errorResponse('Category does not exist', null, 404);
        }
        $category->delete();
        return $this->successResponse('Category delete successfully');
    }

    public function show(string $id)
    {
        $products = Product::where('categoryID', $id)->get();

        if ($products->isEmpty()) {
            return $this->errorResponse("No products found in category with ID $id", null, 404);
        }

        return $this->successResponse("List products in category with ID $id", \App\Http\Resources\Product::collection($products));
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
