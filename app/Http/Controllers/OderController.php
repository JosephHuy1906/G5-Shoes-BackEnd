<?php

namespace App\Http\Controllers;

use App\Http\Resources\Oder as ResourcesOder;
use App\Models\Oder;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OderController extends Controller
{
    public function index()
    {
        $oders = Oder::all();
        return $this->successResponse("List oder", ResourcesOder::collection($oders));
    }
    public function edit(int $id)
    {
        $oders = Oder::with('status')->where('userID', $id)->get();
        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => "List oder for user ",
            'data' =>  $oders->map(function ($item) {
                return new ResourcesOder($item);
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
        $oder = Oder::create([...$input, 'statusID' => 1]);
        Notification::create([
            'oder' => $oder->id,
            'userID' => $request->userID,
            'content' => "Đơn hàng của bạn " . $oder->status->name,
            'notiLevel' => 1
        ]);
        $arr = [
            'status' => 200,
            'success' => true,
            'message' => "Create oder success",
            'data' => new ResourcesOder($oder)
        ];
        return response()->json($arr, 201);
    }

    public function update(Request $request, Oder $oder)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'statusID' => 'required',
        ]);
        $oder->statusID = $input['statusID'];
        $oder->save();
        Notification::create([
            'oderID' => $oder->id,
            'userID' => $oder->userID,
            'content' => "Đơn hàng của bạn " . $oder->status->name,
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
            'message' => 'Oder updated successfully',
            'data' => new ResourcesOder($oder)
        ];
        return response()->json($arr, 200);
    }
}
