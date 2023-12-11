<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OderDetail extends Model
{
    use HasFactory;
    public function product()
    {
        return $this->belongsTo(Product::class, 'productID');
    }
    
    protected $fillable = [
        'oderID',
        'productID',
        'size',
        'price',
        'quantity'
    ];
}
