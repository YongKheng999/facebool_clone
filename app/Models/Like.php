<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    /** @use HasFactory<\Database\Factories\LikeFactory> */
    use HasFactory;
    protected $fillable = [
        'user_id',
        'post_id',
    ];

    public function user(){
        return $this->belongTo(User::class);
    }
    public function post(){
        return $this->belongTo(Post::class);
    }

   


}
