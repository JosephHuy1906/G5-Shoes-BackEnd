<?php

namespace App\Http\Controllers;

use App\Http\Resources\Notification as ResourcesNotification;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller
{
    public function edit(int $id)
    {
        $bills = Notification::with('user')->where('userID', $id)->get();
        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => "List notificaton for user ",
            'data' =>  $bills->map(function ($item) {
                return new ResourcesNotification($item);
            })

        ], 200);
    }
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'userID' => 'required',
            'productID' => 'required',
            'content' => 'required',
            'notiLevel' => 'required'
        ]);
        if ($validator->fails()) {
            $arr = [
                'status' => 404,
                'success' => false,
                'message' => 'Error input values',
                'data' => $validator->errors()
            ];
            return response()->json($arr, 404);
        }

        Notification::create([...$input]);
        $arr = [
            'status' => 200,
            'success' => true,
            'message' => "Notification created",
        ];
        return response()->json($arr, 201);
    }
    public function destroy($id)
    {
        $notification = Notification::find($id);

        if (!$notification) {
            $arr = [
                'status' => 404,
                'success' => false,
                'message' => 'Notification does not exist',
            ];
            return response()->json($arr, 404);
        }

        $notification->delete();

        $arr = [
            'status' => 200,
            'success' => true,
            'message' => 'Notification delete successfully',
        ];

        return response()->json($arr, 200);
    }
}
