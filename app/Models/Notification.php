<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class, 'userID');
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'productID');
    }
    public function notiLevel()
    {
        return $this->belongsTo(NotiLevel::class, 'notiLevel');
    }
    protected $fillable = [
        'productID',
        'userID',
        'content',
        'notiLevel'
    ];
}
