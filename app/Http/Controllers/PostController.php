<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequeust;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
   

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequeust $request)
    {
        $data=$request->validated();
        $post=Post::create($data);

        return back();

    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $post->update($request->validated());
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $id=auth()->user()->id;
        if($post->user_id!=$id){
            return response("You dont have permission to delete this post",403);
        }
        $post->delete();
        return back();
    }
}
