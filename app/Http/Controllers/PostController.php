<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function store(Request $request){
        $data = $request->all();
        $user = Auth::user();

        if ($user != null){
            if ($request->hasFile('image')) {

                $image = $request->file('image');
                $name = time() . "." . $image->getClientOriginalExtension();
                $destinationPath = public_path('/posts');
                $image->move($destinationPath, $name);

                $data['image']  = $name;
            }
            $data['user_id'] = $user->id;

            $post = Post::create($data);

            return response()->json([
                'message' => 'Post created successfully',
                'post' => $post
            ], 201);
        }else{
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
    public function index(){
        $posts = Post::with('user')->latest()->paginate(10);
        foreach ($posts as $post) {
            $post->likeCount = $post->likes->count();
            $post->commentCount = $post->comments->count();

            $post->isLiked = $post->likes->contains('user_id', Auth::id());
       
        }
        return response()->json([
            'posts' => $posts
        ], 200);
    }

    public function show($id){
        $post =Post::with('user')->find($id);
        if($post!= null){
            $post->likeCount = $post->likes->count();
            $post->commentCount = $post->comments->count();
            $post->isLiked = $post->likes->contains('user_id', Auth::id());

            return response()->json([
                'post' => $post
            ], 200);
        }else{
            return response()->json(['error' => 'Post not found'], 404);
        }
    }

    function update(Request $request ,$postId){
        $data = $request->all();
        $user = Auth::user();
        if($user != null){
            $post = Post::find($postId);
            if($post->user_id == $user->id){
                if ($request->hasFile('image')) {

                    $image = $request->file('image');
                    $name = time() . "." . $image->getClientOriginalExtension();
                    $destinationPath = public_path('/posts');
                    $image->move($destinationPath, $name);

                    $data['image']  = $name;
                    $oldImage = $post->image;
                    if($oldImage){
                      if (file_exists(public_path('/posts/' . $oldImage))) {
                            unlink(public_path('/posts/' . $oldImage));
                        }
                    }
                }
                $post->update($data);
                return response()->json([
                    'message' => 'Post updated successfully',
                ]);
            }else{
                return response()->json(['error' => 'Unauthorized'], 401);
            }
        }
    }

    public function destroy($id){
        $user = Auth::user();
        if($user != null){
            $post = Post::find($id);
            if($post->user_id == $user->id){
                $post->delete();
                return response()->json([
                    'message' => 'Post deleted successfully',
                ]);
            }else{
                return response()->json(['error' => 'Unauthorized'], 401);
            }
        }
    }

}