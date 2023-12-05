<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Product extends JsonResource
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
            'tensp' => $this->name,
            'cateID' => $this->categoryID,
            'size' => $this->sizeID,
            'img1' => $this->img1,
            'img2' => $this->img2,
            'img3' => $this->img3,
            'img4' => $this->img4,
            'newPrice' => $this->newPrice,
            'oldPrice' => $this->oldPrice,
            'description' => $this->description,
            'created_at' => $this->created_at->format('d/m/Y'),
            'updated_at' => $this->updated_at->format('d/m/Y'),
        ];
    }
}
