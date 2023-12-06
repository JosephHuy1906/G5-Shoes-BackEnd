<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BillDetail extends JsonResource
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
            'billID' => $this->billID,
            'product' => [
                'productID' => $this->productID,
                'name' => $this->product->name,
                'img1' => $this->product->img1,
                'newPrice' => $this->product->newPrice,
                'oldPrice' => $this->product->oldPrice,
            ],
            'sizeID' => $this->sizeID,
            'userID' => $this->userID,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'created_at' => $this->created_at->format('d/m/Y'),
            'updated_at' => $this->updated_at->format('d/m/Y'),
        ];
    }
}
