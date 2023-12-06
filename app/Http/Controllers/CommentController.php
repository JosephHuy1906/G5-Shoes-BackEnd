<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function index()
    {
        $comment = Comment::all();
        return $this->successResponse("List Comment", \App\Http\Resources\Comment::collection($comment));
    }
    public function store(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                "userID" => 'required',
                "productID" => 'required',
                "content" => 'required',
            ]);

            if ($validator->fails()) {
                return $this->errorResponse('Input value error', $validator->errors(), 400);
            }

            $product = Comment::create($request->all());
            return $this->successResponse("Create Product successfully", new \App\Http\Resources\Comment($product), 201);
        } catch (Exception $e) {
            return response()->json(['error' . $e], 500);
        }
    }

    public function show(string $id)
    {
        $comment = Comment::where('productID', $id)->get();
        if ($comment->isEmpty()) {
            return $this->errorResponse("No comment found in product with ID $id", null, 404);
        }
        return $this->successResponse("List comment in product with ID $id", \App\Http\Resources\Comment::collection($comment));
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
