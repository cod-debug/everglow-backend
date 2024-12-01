<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MoodBoardModel extends Model
{
    use HasFactory;
    protected $table = "moodboard";
    
    protected $fillable = [
        'ip_address',
        'mood',
        'day'
    ];
}
