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
    public function show(string $id)
    {
        $feedback = Feedback::where('commentID', $id)->get();

        if ($feedback->isEmpty()) {
            return $this->errorResponse("No feedback found in comment with ID $id", null, 404);
        }

        return $this->successResponse("List feedback in comment with ID $id", \App\Http\Resources\Feedback::collection($feedback));
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
