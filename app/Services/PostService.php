<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Post;
use App\Models\View;
use App\Traits\HandlesImageUpload;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;

class PostService
{
    use HandlesImageUpload;

    public function getPosts()
    {
        return Post::with(['category', 'user.profile'])->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
    }

    public function getCreatePostFormData(): array
    {
        $categories = Category::all();       // all categories
        $postStatuses = Post::statuses();    // static method for statuses

        return compact('categories', 'postStatuses');
    }

    public function createPost(array $data, $authorId)
    {
        $data['author_id'] = $authorId;

        return Post::create($data);
    }

    public function createPostFromRequest(array $validatedData, ?UploadedFile $imageFile = null): Post
    {
        // handle image upload if exists
        if ($imageFile) {
            $validatedData['image'] = $imageFile->store('images', 'public');
        }
        $validatedData['tags'] = array_map('trim', explode(',', $validatedData['tags']));
        // set the author
        $validatedData['author_id'] = Auth::id();

        // create post
        return Post::create($validatedData);
    }

    public function updatePostFromRequest(Post $post, array $validatedData, ?UploadedFile $imageFile = null)
    {
        $validatedData['tags'] = array_map('trim', explode(',', $validatedData['tags']));
        $validatedData['image'] = $this->updateImage($imageFile, $post->image);
        return $post->update(
            $validatedData
        );
    }

    /**
     * Increment views if the user hasn't viewed this post in the session
     */
    public function incrementPostViews(Post $post): void
    {
        if (Auth::check() && ! Auth::user()->isAdmin()) {
            if (! session()->has('post_'.$post->id)) {
                $post->increment('views');
                session()->put('post_'.$post->id, true);

                View::updateOrCreate(
                    [
                        'post_id' => $post->id,
                        'user_id' => Auth::id(),
                    ],
                    [
                        'ip_address' => request()->ip(),
                    ]
                );
            }
        }
    }

    public function getPostWithRelated(int $postId, int $relatedCount = 3)
    {
        $post = Post::with(['category','user.profile'])->findOrFail($postId);

        $relatedPosts = Post::where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->with('category')
            ->latest()
            ->take($relatedCount)
            ->get();

        return [
            'post' => $post,
            'relatedPosts' => $relatedPosts,
        ];
    }
}
