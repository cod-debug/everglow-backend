<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionCommentModel extends Model
{
    use HasFactory;

    protected $table="session_comments";

    protected $fillable = [
        'session_type',
        'ip_address',
        'comment',
        'image_name'
    ];
}
