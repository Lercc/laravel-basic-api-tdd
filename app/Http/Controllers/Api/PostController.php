<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
// use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;

class PostController extends Controller
{

    public function index()
    {
        $posts = Post::paginate();

        return response()->json($posts);
    }


    public function store(PostRequest $request)
    {
        $post = Post::create($request->all());
        return response()->json($post, 201);
    }


    public function show(Post $post)
    {
        return response()->json($post);
    }

    
    public function update(PostRequest $request, Post $post)
    {
        $post->update($request->validated());

        return response()->json($post);
    }

  
    public function destroy(Post $post)
    {
        $post->delete();
        return response()->json(null, 204);
    }
}
