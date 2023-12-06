<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Feedback extends JsonResource
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
            'comment' => [
                'commentID' => $this->commentID,
                'content' => $this->comment->content,

            ],
            'user' => [
                'userID' => $this->userID,
                'name' => $this->user->name,
                'avatar' => $this->user->avatar,
            ],
            'content' => $this->content,
            'created_at' => $this->created_at->format('d/m/Y'),
            'updated_at' => $this->updated_at->format('d/m/Y'),
        ];
    }
}
