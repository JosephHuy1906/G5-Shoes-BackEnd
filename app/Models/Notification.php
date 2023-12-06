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

    public function notiLevel()
    {
        return $this->belongsTo(NotiLevel::class, 'notiLevel');
    }
    public function bill()
    {
        return $this->belongsTo(Bill::class, 'billID');
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'productID');
    }
    protected $fillable = [
        'productID',
        'billID',
        'userID',
        'content',
        'notiLevel'
    ];
}
