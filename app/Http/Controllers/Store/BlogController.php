<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $categories = BlogCategory::where('status', 1)->withCount('blogPosts')->get();
        $query = BlogPost::where('status', 'published')->orderBy('created_at', 'desc');

        // Filter by multiple categories if provided and not empty
        if ($request->has('categories') && !empty($request->categories) && is_array($request->categories)) {
            $categorySlugs = $request->categories; // Already an array from the form
            $categoryIds = BlogCategory::whereIn('slug', $categorySlugs)->where('status', 1)->pluck('id')->toArray();
            if (!empty($categoryIds)) {
                $query->whereIn('blog_category_id', $categoryIds);
            }
        }

        $blogPosts = $query->paginate(9); // Set to 9 posts per page
        return view('store.pages.blog-index', compact('categories', 'blogPosts'));
    }

    public function show($slug)
    {
        $blogPost = BlogPost::where('slug', $slug)->where('status', 'published')->firstOrFail();
        return view('store.pages.blog-show', compact('blogPost'));
    }
}
