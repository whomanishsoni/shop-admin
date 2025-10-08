<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;

class AccountController extends Controller
{
    public function login()
    {
        $loginData = []; // Placeholder for login form data
        return view('store.pages.account.login', compact('loginData'));
    }

    public function loginAttempt()
    {
        // Placeholder for login attempt logic
        return redirect()->route('profile');
    }

    public function register()
    {
        $registerData = []; // Placeholder for registration form data
        return view('store.pages.account.register', compact('registerData'));
    }

    public function registerAttempt()
    {
        // Placeholder for registration attempt logic
        return redirect()->route('profile');
    }

    public function profile()
    {
        $profileData = [
            [
                'name' => 'Rajesh',
                'email' => 'rajesh@gmail.com',
                'contact_no' => '+91-9876543210',
                'alt_contact_no' => '+91-9876543210',
                'address' => '#101, Bank House Colony, Hyderabad, Telangana - 500001',
            ],
        ];

        return view('store.pages.account.profile', compact('profileData'));
    }

    public function editProfile()
    {
        $profileData = [
            [
                'name' => 'Rajesh',
                'email' => 'rajesh@gmail.com',
                'contact_no' => '+91-9876543210',
                'alt_contact_no' => '+91-9876543210',
                'address' => '#101, Bank House Colony',
                'city' => 'Hyderabad',
                'country' => 'India',
                'state' => 'Telangana',
                'postal_code' => '500001',
                'liked' => false,
            ],
        ];

        return view('store.pages.account.edit_profile', compact('profileData'));
    }

    public function orders()
    {
        // Handled by OrderController
        return redirect()->route('orders');
    }

    public function addresses()
    {
        $addresses = [
            [
                'id' => 1,
                'name' => 'Mr. Rajesh',
                'address' => '#101, Bank House Colony, Hyderabad, Telangana - 500001',
                'is_default' => true,
                'liked' => false,
            ],
            [
                'id' => 2,
                'name' => 'Mr. Rajesh',
                'address' => '#202, Green Valley, Hyderabad, Telangana - 500002',
                'is_default' => false,
                'liked' => true,
            ],
        ];

        return view('store.pages.account.addresses', compact('addresses'));
    }

    public function logout()
    {
        // Placeholder for logout logic (static for now)
        return view('store.pages.account.logout')->with('success', 'You have been logged out.');
    }
}
