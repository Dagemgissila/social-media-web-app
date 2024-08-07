<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequeust;
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
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
