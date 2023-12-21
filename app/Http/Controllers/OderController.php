<?php

namespace App\Http\Controllers;

// use App\Http\Resources\Oder as ResourcesOder;

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
        if (is_null($oders)) {
            return $this->errorResponse('Oder does not exist', null, 404);
        }
        return $this->successResponse("List oder for user", $oders->map(function ($item) {
            return new ResourcesOder($item);
        }));
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
            return $this->errorResponse('Input error value', $validator->errors(), 400);
        }
        $checkUser = User::find($request->userID);
        if (!$checkUser) {

            return $this->errorResponse('User is already exist', $validator->errors(), 400);
        }
        $oder = Oder::create([...$input, 'statusID' => 1]);
        Notification::create([
            'oder' => $oder->id,
            'userID' => $request->userID,
            'content' => "Đơn hàng của bạn " . $oder->status->name,
            'notiLevel' => 1
        ]);
        return $this->successResponse('Create oder success', new ResourcesOder($oder));
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
            return $this->errorResponse('Input error value', $validator->errors(), 400);
        }

        return $this->successResponse('Oder updated successfully', new ResourcesOder($oder));
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
