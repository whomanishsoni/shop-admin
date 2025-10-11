<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Page;

class LegalController extends Controller
{
    public function privacyPolicy()
    {
        $pageData = Page::where('slug', 'privacy-policy')
            ->where('status', 1)
            ->first() ?? new Page([
                'title' => 'Privacy Policy',
                'content' => '<p>Content not found. Please configure the Privacy Policy page in the admin panel.</p>',
                'meta_title' => 'Privacy Policy - Vyuga',
                'meta_description' => 'Learn more about Vyuga’s policies and procedures.'
            ]);

        return view('store.pages.legal.privacy-policy', compact('pageData'));
    }

    public function termsConditions()
    {
        $pageData = Page::where('slug', 'terms-conditions')
            ->where('status', 1)
            ->first() ?? new Page([
                'title' => 'Terms & Conditions',
                'content' => '<p>Content not found. Please configure the Terms & Conditions page in the admin panel.</p>',
                'meta_title' => 'Terms & Conditions - Vyuga',
                'meta_description' => 'Learn more about Vyuga’s policies and procedures.'
            ]);

        return view('store.pages.legal.terms-conditions', compact('pageData'));
    }

    public function refundPolicy()
    {
        $pageData = Page::where('slug', 'refund-policy')
            ->where('status', 1)
            ->first() ?? new Page([
                'title' => 'Refund Policy',
                'content' => '<p>Content not found. Please configure the Refund Policy page in the admin panel.</p>',
                'meta_title' => 'Refund Policy - Vyuga',
                'meta_description' => 'Learn more about Vyuga’s policies and procedures.'
            ]);

        return view('store.pages.legal.refund-policy', compact('pageData'));
    }

    public function shippingPolicy()
    {
        $pageData = Page::where('slug', 'shipping-policy')
            ->where('status', 1)
            ->first() ?? new Page([
                'title' => 'Shipping Policy',
                'content' => '<p>Content not found. Please configure the Shipping Policy page in the admin panel.</p>',
                'meta_title' => 'Shipping Policy - Vyuga',
                'meta_description' => 'Learn more about Vyuga’s policies and procedures.'
            ]);

        return view('store.pages.legal.shipping-policy', compact('pageData'));
    }
}
