<?php

namespace App\Http\Controllers;

use App\Http\Resources\Bill as ResourcesBill;
use App\Models\Bill;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BillController extends Controller
{

    public function edit(int $id)
    {
        $bills = Bill::with('status')->where('userID', $id)->get();
        $user = User::find($id);
        $userData = [
            'name' => $user->name,
            'avatar' => $user->avatar,
        ];

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => "Danh sách bill của user ",
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
                'message' => 'Lỗi kiểm tra dữ liệu',
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
        $arr = [
            'status' => 200,
            'success' => true,
            'message' => "Bill đã được thêm",
            'data' => new \App\Http\Resources\Bill($bill)
        ];
        return response()->json($arr, 201);
    }
}
