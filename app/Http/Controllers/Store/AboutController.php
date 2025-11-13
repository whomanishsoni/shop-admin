<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Page;

class AboutController extends Controller
{
    public function __invoke()
    {
        // Fetch the "About Us" page content from the database by slug
        $aboutData = Page::where('slug', 'about-us')
            ->where('status', 1) // Only active pages
            ->first();

        // Fallback if page not found
        if (!$aboutData) {
            $aboutData = new Page([
                'title' => 'About Us',
                'content' => '<p>Content not found. Please configure the About Us page in the admin panel.</p>',
                'meta_title' => 'About Us - Waseem Fashion Studio',
                'meta_description' => 'Discover Waseem Fashion Studio, your go-to online store for stylish and high-quality women’s clothing.'
            ]);
        }

        return view('store.pages.about', compact('aboutData'));
    }
}
