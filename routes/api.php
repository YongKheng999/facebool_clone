<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {
    //update 
    Route::post('/update', [AuthController::class, 'update']);
    //delete
    Route::delete('/delete', [AuthController::class, 'destroy']);
    // current user loggin 
    Route::post('/me', [AuthController::class, 'me']);

    // posts 

    Route::post('/posts', [PostController::class, 'store']);
    Route::get('/posts', [PostController::class, 'index']);
    Route::get('/posts/{id}', [PostController::class, 'show']);
    //update posts 
    Route::post('/posts/{id}', [PostController::class, 'update']);
    //delete posts
    Route::delete('/posts/{id}', [PostController::class, 'destroy']);

    //Likes Routes 
    Route::post('/like-dislike/{id}', [LikeController::class, 'likeDisLike']);
    Route::get('/likes/{id}', [LikeController::class, 'show']);

    // comments 
    Route::post('/comments', [CommentController::class, 'store']);
    Route::get('/comments/{id}', [CommentController::class, 'show']);
});
