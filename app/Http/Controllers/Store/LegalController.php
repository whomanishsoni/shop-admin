<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;

class LegalController extends Controller
{
    public function privacyPolicy()
    {
        return view('store.pages.legal.privacy-policy');
    }

    public function termsConditions()
    {
        return view('store.pages.legal.terms-conditions');
    }

    public function refundPolicy()
    {
        return view('store.pages.legal.refund-policy');
    }

    public function shippingPolicy()
    {
        return view('store.pages.legal.shipping-policy');
    }
}
