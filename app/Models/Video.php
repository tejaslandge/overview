<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = [
        'title',
        'file_path',
        'thumbnail_path',
        'description',
        'category',
        'is_active',
        'views'
    ];
}
