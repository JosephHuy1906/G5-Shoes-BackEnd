<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "user_id" => 'required',
            "productID" => 'required',
            "content" => 'required',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Input value error', $validator->errors(), 400);
        }

        $product = Comment::create($request->all());
        return $this->successResponse("Create Product successfully", new \App\Http\Resources\Comment($product), 201);
    }
}
