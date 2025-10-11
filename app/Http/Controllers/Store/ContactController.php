<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Setting;

class ContactController extends Controller
{
    public function __invoke()
    {
        $settings = Setting::whereIn('key', [
            'site_address',
            'site_email',
            'site_phone'
        ])->pluck('value', 'key')->toArray();

        return view('store.pages.contact', compact('settings'));
    }
}
