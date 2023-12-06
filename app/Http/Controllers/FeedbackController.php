<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FeedbackController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'commentID' => 'required',
            'userID' => 'required',
            'content' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Input value error', $validator->errors(), 400);
        }

        $product = Feedback::create($request->all());
        return $this->successResponse("Create Product successfully", new \App\Http\Resources\Feedback($product), 201);
    }
}
