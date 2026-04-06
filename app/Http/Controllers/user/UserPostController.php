<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Services\PostService;

class UserPostController extends Controller
{
    protected PostService $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $data = $this->postService->getCreatePostFormData();
        return view('user.create-post', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        $post = $this->postService->createPostFromRequest(
            $request->validated(),                // current user/admin
            $request->file('image')       // uploaded image
        );

        return redirect()->back()->with('success', 'Post created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $data = $this->postService->getPostWithRelated($post->id);
        $this->postService->incrementPostViews($post);

        return view('post', $data);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = Post::findOrFail($id);
        $formData = $this->postService->getCreatePostFormData();

        return view('user.create-post', array_merge(['post' => $post], $formData));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, string $id)
    {
        $post = Post::findOrFail($id);
        $this->postService->updatePostFromRequest(
            $post,
            $request->validated(),
            $request->file('image') // optional new image
        );

        return redirect()->route('home')->with('success', 'Post updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect()->back()->with('success', 'Post deleted successfully');
    }
}
