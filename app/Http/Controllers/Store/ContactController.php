<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;

class ContactController extends Controller
{
    public function __invoke()
    {
        $contactData = []; // Placeholder for contact info
        return view('store.pages.contact', compact('contactData'));
    }
}
