<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BlogPostController extends Controller
{
    use ImageProcessable;

    public function __construct()
    {
        // Increase PHP limits for file uploads
        ini_set('upload_max_filesize', '100M');
        ini_set('post_max_size', '100M');
        ini_set('memory_limit', '512M');
    }

    public function index()
    {
        $blogPosts = BlogPost::with(['blogCategory', 'author'])->latest()->paginate(10);
        return view('admin.blog-posts.index', compact('blogPosts'));
    }

    public function create()
    {
        $categories = BlogCategory::all();
        return view('admin.blog-posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'slug' => 'nullable|string|unique:blog_posts,slug',
                'content' => 'required|string',
                'blog_category_id' => 'required|exists:blog_categories,id',
                'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
                'status' => 'required|in:draft,published',
            ]);

            $validated['slug'] = $validated['slug'] ?? Str::slug($validated['title']);
            $validated['author_id'] = auth()->id();

            if ($request->hasFile('featured_image')) {
                $validated['featured_image'] = $this->processImage($request->file('featured_image'), 'blog-posts');
            }

            BlogPost::create($validated);

            return redirect()->route('admin.blog-posts.index')->with('success', 'Blog post created successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors());
        } catch (\Exception $e) {
            \Log::error('Blog post creation failed: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to create blog post. Please try with a smaller image.']);
        }
    }

    public function show(BlogPost $blogPost)
    {
        $blogPost->load(['blogCategory', 'author']);
        return view('admin.blog-posts.show', compact('blogPost'));
    }

    public function edit(BlogPost $blogPost)
    {
        $categories = BlogCategory::all();
        return view('admin.blog-posts.edit', compact('blogPost', 'categories'));
    }

    public function update(Request $request, BlogPost $blogPost)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'slug' => 'nullable|string|unique:blog_posts,slug,' . $blogPost->id,
                'content' => 'required|string',
                'blog_category_id' => 'required|exists:blog_categories,id',
                'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
                'remove_image' => 'nullable|boolean',
                'status' => 'required|in:draft,published',
            ]);

            $validated['slug'] = $validated['slug'] ?? Str::slug($validated['title']);

            if ($request->has('remove_image') && $request->remove_image) {
                if ($blogPost->featured_image) {
                    Storage::disk('public')->delete($blogPost->featured_image);
                }
                $validated['featured_image'] = null;
            } elseif ($request->hasFile('featured_image')) {
                if ($blogPost->featured_image) {
                    Storage::disk('public')->delete($blogPost->featured_image);
                }
                $validated['featured_image'] = $this->processImage($request->file('featured_image'), 'blog-posts');
            }

            $blogPost->update($validated);

            return redirect()->route('admin.blog-posts.index')->with('success', 'Blog post updated successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors());
        } catch (\Exception $e) {
            \Log::error('Blog post update failed: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to update blog post. Please try with a smaller image.']);
        }
    }

    public function destroy(BlogPost $blogPost)
    {
        $blogPost->delete();
        return redirect()->route('admin.blog-posts.index')->with('success', 'Blog post deleted successfully.');
    }

    public function bulkDelete(Request $request)
    {
        BlogPost::whereIn('id', $request->ids)->delete();
        return response()->json(['success' => true]);
    }

    public function comments($id)
    {
        $blogPost = BlogPost::with('author')->findOrFail($id);
        return view('admin.blog-posts.comments', compact('blogPost'));
    }
}
