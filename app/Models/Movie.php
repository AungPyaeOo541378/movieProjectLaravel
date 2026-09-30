<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $fillable = [
        'title',
        'image',
        'image_type',
        'description',
        'movie_type',
        'director',
        'rating',
        'duration',
        'release_date',
    ];
}
