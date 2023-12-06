<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function category()
    {
        return $this->belongsTo(Category::class, 'categoryID');
    }
    protected $fillable = [
        'name',
        'categoryID',
        'sizeID',
        'img1',
        'img2',
        'img3',
        'img4',
        'newPrice',
        'oldPrice',
        'description'
    ];
}
