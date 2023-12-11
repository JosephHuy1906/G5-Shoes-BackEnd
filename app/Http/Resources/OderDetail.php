<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OderDetail extends JsonResource
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
            'oderID' => $this->oderID,
            'product' => [
                'productID' => $this->productID,
                'name' => $this->product->name,
                'img1' => $this->product->img1,
                'newPrice' => $this->product->newPrice,
                'oldPrice' => $this->product->oldPrice,
            ],
            'size' => $this->size,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'created_at' => $this->created_at->format('d/m/Y'),
            'updated_at' => $this->updated_at->format('d/m/Y'),
        ];
    }
}
