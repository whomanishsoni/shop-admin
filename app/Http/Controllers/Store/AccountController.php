<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AccountController extends Controller
{
    public function login()
    {
        return view('store.pages.account.login');
    }

    public function loginAttempt(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::guard('customer')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->route('profile')->with('success', 'Logged in successfully');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function register()
    {
        return view('store.pages.account.login');
    }

    public function registerAttempt(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'password' => 'required|string|min:8|confirmed',
            'terms' => 'accepted',
        ]);

        $nameParts = explode(' ', trim($validated['name']));
        $firstName = $nameParts[0];
        $lastName = isset($nameParts[1]) ? implode(' ', array_slice($nameParts, 1)) : '';

        $customer = Customer::create([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::guard('customer')->login($customer);
        $request->session()->regenerate();

        return redirect()->route('profile')->with('success', 'Registered and logged in successfully');
    }

    public function forgotPassword(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate(['email' => 'required|email']);
            $status = Password::broker('customers')->sendResetLink(
                $request->only('email')
            );
            return $status === Password::RESET_LINK_SENT
                ? back()->with('success', __($status))
                : back()->withErrors(['email' => __($status)]);
        }
        return view('store.pages.account.forgot_password');
    }

    public function profile()
    {
        $customer = Auth::guard('customer')->user();
        if (!$customer) {
            return redirect()->route('login')->with('error', 'Please log in to view your profile.');
        }

        $profileData = [
            'first_name' => $customer->first_name,
            'last_name' => $customer->last_name,
            'email' => $customer->email,
            'contact_no' => $customer->contact_no,
            'alternative_contact_no' => $customer->alternative_contact_no,
        ];

        return view('store.pages.account.profile', compact('profileData'));
    }

    public function editProfile()
    {
        $customer = Auth::guard('customer')->user();
        if (!$customer) {
            return redirect()->route('login')->with('error', 'Please log in to edit your profile.');
        }

        $profileData = [
            'first_name' => $customer->first_name,
            'last_name' => $customer->last_name,
            'email' => $customer->email,
            'contact_no' => $customer->contact_no,
            'alternative_contact_no' => $customer->alternative_contact_no,
        ];

        return view('store.pages.account.edit_profile', compact('profileData'));
    }

    public function updateProfile(Request $request)
    {
        $customer = Auth::guard('customer')->user();
        if (!$customer) {
            return redirect()->route('login')->with('error', 'Please log in to update your profile.');
        }

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email,'.$customer->id,
            'contact_no' => 'nullable|string|max:20',
            'alternative_contact_no' => 'nullable|string|max:20',
        ]);

        $customer->update($validated);

        return redirect()->route('profile')->with('success', 'Profile updated successfully');
    }

    public function orders()
    {
        return redirect()->route('orders');
    }

    public function addresses()
    {
        $customer = Auth::guard('customer')->user();
        if (!$customer) {
            return redirect()->route('login')->with('error', 'Please log in to view your addresses.');
        }

        $addresses = $customer->addresses()->get()->toArray();

        return view('store.pages.account.addresses', compact('addresses'));
    }

    public function createAddress()
    {
        $customer = Auth::guard('customer')->user();
        if (!$customer) {
            return redirect()->route('login')->with('error', 'Please log in to add an address.');
        }

        return view('store.pages.account.address_form', [
            'action' => 'Add',
            'address' => [],
        ]);
    }

    public function storeAddress(Request $request)
    {
        $customer = Auth::guard('customer')->user();
        if (!$customer) {
            return redirect()->route('login')->with('error', 'Please log in to add an address.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'pincode' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'is_default' => 'boolean',
        ]);

        if ($validated['is_default']) {
            $customer->addresses()->update(['is_default' => false]);
        }

        $customer->addresses()->create($validated);

        return redirect()->route('addresses')->with('success', 'Address added successfully');
    }

    public function editAddress($id)
    {
        $customer = Auth::guard('customer')->user();
        if (!$customer) {
            return redirect()->route('login')->with('error', 'Please log in to edit an address.');
        }

        $address = $customer->addresses()->find($id);
        if (!$address) {
            return redirect()->route('addresses')->with('error', 'Address not found.');
        }

        return view('store.pages.account.address_form', [
            'action' => 'Edit',
            'address' => $address->toArray(),
        ]);
    }

    public function updateAddress(Request $request, $id)
    {
        $customer = Auth::guard('customer')->user();
        if (!$customer) {
            return redirect()->route('login')->with('error', 'Please log in to update an address.');
        }

        $address = $customer->addresses()->find($id);
        if (!$address) {
            return redirect()->route('addresses')->with('error', 'Address not found.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'pincode' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'is_default' => 'boolean',
        ]);

        if ($validated['is_default']) {
            $customer->addresses()->where('id', '!=', $id)->update(['is_default' => false]);
        }

        $address->update($validated);

        return redirect()->route('addresses')->with('success', 'Address updated successfully');
    }

    public function deleteAddress(Request $request, $id)
    {
        $customer = Auth::guard('customer')->user();
        if (!$customer) {
            return redirect()->route('login')->with('error', 'Please log in to delete an address.');
        }

        $address = $customer->addresses()->find($id);
        if (!$address) {
            return redirect()->route('addresses')->with('error', 'Address not found.');
        }

        $address->delete();

        return redirect()->route('addresses')->with('success', 'Address deleted successfully');
    }

    public function likeAddress(Request $request, $id)
    {
        $customer = Auth::guard('customer')->user();
        if (!$customer) {
            return redirect()->route('login')->with('error', 'Please log in to like an address.');
        }

        $address = $customer->addresses()->find($id);
        if (!$address) {
            return redirect()->route('addresses')->with('error', 'Address not found.');
        }

        $address->update(['liked' => !$address->liked]);

        return redirect()->route('addresses')->with('success', 'Address like status updated.');
    }

    public function logout(Request $request)
    {
        Auth::guard('customer')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'You have been logged out.');
    }
}
