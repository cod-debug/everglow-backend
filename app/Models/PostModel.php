<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostModel extends Model
{
    use HasFactory;

    protected $table = "posts";

    protected $fillable =[
        'ip_address',
        'caption',
        'image_name'
    ];
}