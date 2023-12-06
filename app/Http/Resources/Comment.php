<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Comment extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user' => [
                'userID' => $this->userID,
                'name' => $this->user->name,
                'avatar' => $this->user->avatar,
            ],
            'product' => [
                'productID' => $this->productID,
                'name' => $this->product->name,
                'img1' => $this->product->img1,

            ],
            'content' => $this->content,
            'created_at' => $this->created_at->format('d/m/Y'),
            'updated_at' => $this->updated_at->format('d/m/Y'),
        ];
    }
}
