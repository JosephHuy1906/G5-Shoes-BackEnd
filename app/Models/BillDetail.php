<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillDetail extends Model
{
    use HasFactory;
    public function product()
    {
        return $this->belongsTo(Product::class, 'productID');
    }
    public function size()
    {
        return $this->belongsTo(Size::class, 'sizeID');
    }
    protected $fillable = [
        'billID',
        'productID',
        'sizeID',
        'userID',
        'price',
        'quantity'
    ];
}
