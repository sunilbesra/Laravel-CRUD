<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model; // 👈 use MongoDB model, not the default one

class Post extends Model
{
    protected $connection = 'mongodb';   // 👈 tells Laravel to use MongoDB
    protected $collection = 'posts';     // 👈 your MongoDB collection

    protected $fillable = [
        'title',
        'content',
        'author',
        'created_at'
    ];
}
