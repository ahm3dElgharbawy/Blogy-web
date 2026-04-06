<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $postPerPage = Setting::getValue('posts_per_page');
        $posts = Post::query();
        // return $posts->whereJsonContains('tags', $request->tag)->get();
        if ($query = $request->input('query')) {
            $posts->where('title', 'like' , "%$query%");
        } elseif ($request->category) {
            $posts->whereHas('category', function ($q) use ($request) {
                $q->where('name', $request->category);
            });
        } elseif ($request->tag) {
            $posts->whereJsonContains('tags', $request->tag);
        }

        $posts = $posts->latest()->paginate($postPerPage)->withQueryString();
        $categories = Category::withCount('post')->get();
        $popularTags = $this->getPopularTags();
        $featuredPost = Post::featured()->with('category')->first();

        return view('user.index', compact('posts', 'categories', 'popularTags', 'featuredPost'));
    }

    private function getPopularTags()
    {

        $popularTags = Cache::remember('popular_tags', 3600, function () {
            $tags = Post::pluck('tags');

            $collection = collect();

            foreach ($tags as $tagList) {
                foreach ($tagList as $tag) {
                    $collection->push($tag);
                }
            }

            return $collection
                ->countBy()
                ->sortDesc()
                ->take(10);
        });

        return $popularTags;
    }

}
