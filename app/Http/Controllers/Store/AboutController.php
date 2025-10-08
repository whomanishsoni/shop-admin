<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;

class AboutController extends Controller
{
    public function __invoke()
    {
        $aboutData = []; // Placeholder for about content
        return view('store.pages.about', compact('aboutData'));
    }
}
