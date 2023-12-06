<?php

namespace App\Http\Controllers;

use App\Http\Resources\Bill as ResourcesBill;
use App\Models\Bill;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BillController extends Controller
{
    public function index()
    {
        $bills = Bill::all();
        return $this->successResponse("List Bill", ResourcesBill::collection($bills));
    }
    public function edit(int $id)
    {
        $bills = Bill::with('status')->where('userID', $id)->get();
        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => "List bill for user ",
            'data' =>  $bills->map(function ($item) {
                return new ResourcesBill($item);
            })

        ], 200);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'userID' => 'required',
            'total' => 'required',
            'address' => 'required',
            'phone' => 'required',
        ]);
        if ($validator->fails()) {
            $arr = [
                'status' => 404,
                'success' => false,
                'message' => 'Input value error',
                'data' => $validator->errors()
            ];
            return response()->json($arr, 404);
        }
        $checkUser = User::find($request->userID);
        if (!$checkUser) {
            return response()->json([
                "status" => 400,
                'success' => false,
                'message' => 'User is already exist'
            ], 400);
        }
        $bill = Bill::create([...$input, 'statusID' => 1]);
        Notification::create([
            'bill' => $bill->id,
            'userID' => $request->userID,
            'content' => "Đơn hàng của bạn " . $bill->status->name,
            'notiLevel' => 1
        ]);
        $arr = [
            'status' => 200,
            'success' => true,
            'message' => "Create bill success",
            'data' => new ResourcesBill($bill)
        ];
        return response()->json($arr, 201);
    }

    public function update(Request $request, Bill $bill)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'statusID' => 'required',
        ]);
        $bill->statusID = $input['statusID'];
        $bill->save();
        Notification::create([
            'billID' => $bill->id,
            'userID' => $bill->userID,
            'content' => "Đơn hàng của bạn " . $bill->status->name,
            'notiLevel' => 1
        ]);
        if ($validator->fails()) {
            $arr = [
                'success' => false,
                'message' => 'Input error value',
                'data' => $validator->errors()
            ];
            return response()->json($arr, 400);
        }

        $arr = [
            'status' => true,
            'message' => 'Bill updated successfully',
            'data' => new ResourcesBill($bill)
        ];
        return response()->json($arr, 200);
    }
}
