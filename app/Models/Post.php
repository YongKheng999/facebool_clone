<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory;

    protected $fillable = [
        'caption',
        'image',
    ];

    public function user(){
        return $this->belongTo(User::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }
    public function like()
    {
        return $this->hasMany(Like::class);
    }
}
