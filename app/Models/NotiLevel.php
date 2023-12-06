<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotiLevel extends Model
{
    use HasFactory;
    protected $table = 'notiLevel';
    protected $fillable = [
        'name'
    ];
}
