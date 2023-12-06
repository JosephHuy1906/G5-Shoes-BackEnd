<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    public function status()
    {
        return $this->belongsTo(Status::class, 'statusID');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'userID');
    }

    // Accessor để lấy giá trị của trường 'name' từ bảng 'status'
   
    protected $fillable = [
        'userID',
        'total',
        'address',
        'statusID',
        'phone'
    ];
}
