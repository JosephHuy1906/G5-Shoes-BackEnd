<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Bill extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user' => [
                'userID' => $this->userID,
                'User_name' => $this->user->name,
                'User_avatar' => $this->user->avatar,
            ],
            'total' => $this->total,
            'address' => $this->address,
            'phone' => $this->phone,
            'status' => [
                'statusID' => $this->statusID,
                'name' => $this->status->name,
            ],
            'created_at' => $this->created_at->format('d/m/Y'),
            'updated_at' => $this->updated_at->format('d/m/Y'),
        ];
    }
}
