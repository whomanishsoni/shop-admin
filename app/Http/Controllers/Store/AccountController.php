<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Address;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AccountController extends Controller
{
    public function login()
    {
        return view('store.pages.account.login');
    }

    public function loginAttempt(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::guard('customer')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            $customer = Auth::guard('customer')->user();

            if (!$customer->hasVerifiedEmail()) {
                Auth::guard('customer')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return back()->withErrors(['email' => 'Please verify your email address to login.'])->withInput();
            }

            return redirect()->route('profile')->with('success', 'Logged in successfully');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function register()
    {
        return view('store.pages.account.register');
    }

    public function registerAttempt(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:customers,email'],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'
            ],
            'terms' => ['accepted'],
        ], [
            'password.regex' => 'The password must contain at least 1 uppercase letter, 1 lowercase letter, 1 number, and 1 special character (@$!%*?&).',
            'password.min' => 'The password must be at least 8 characters long.',
            'password.confirmed' => 'The password confirmation does not match.',
        ]);

        $nameParts = explode(' ', trim($validated['name']));
        $firstName = $nameParts[0];
        $lastName = isset($nameParts[1]) ? implode(' ', array_slice($nameParts, 1)) : '';

        $customer = Customer::create([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'email_verified_at' => null,
        ]);

        // Generate and store verification token
        $token = Str::random(32);
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $customer->email],
            [
                'email' => $customer->email,
                'token' => Hash::make($token),
                'created_at' => now(),
            ]
        );

        // Log token and hash
        Log::info('Stored verification token', [
            'email' => $customer->email,
            'token' => $token,
            'hash' => sha1($customer->email),
        ]);

        // Send verification email
        $template = EmailTemplate::where('name', 'New Customer Registration')
            ->where('status', 1)
            ->first();

        if (!$template) {
            Log::error('Email verification template not found for user: ' . $customer->email);
        } else {
            $verificationUrl = route('verify.email') . '?id=' . $customer->id . '&hash=' . sha1($customer->email) . '&token=' . urlencode($token);
            Log::info('Generated verification URL: ' . $verificationUrl);

            $data = [
                'user_name' => $customer->first_name . ' ' . $customer->last_name,
                'user_email' => $customer->email,
                'site_name' => config('app.name'),
                'site_url' => config('app.url'),
                'verification_link' => $verificationUrl,
            ];

            $subject = $this->replaceTemplateVariables($template->subject, $data);
            $body = $this->replaceTemplateVariables($template->body, $data);

            try {
                Mail::html($body, function ($message) use ($customer, $subject) {
                    $message->to($customer->email)
                            ->subject($subject)
                            ->from(config('mail.from.address'), config('mail.from.name'));
                });
                Log::info('Verification email sent to: ' . $customer->email);
            } catch (\Exception $e) {
                Log::error('Failed to send verification email to ' . $customer->email . ': ' . $e->getMessage());
            }
        }

        return redirect()->route('login')->with('success', 'Registration successful! Please check your email to verify your account.');
    }

    public function verifyEmail(Request $request)
    {
        Log::info('Verify email route accessed', $request->all());

        $request->validate([
            'id' => ['required', 'exists:customers,id'],
            'hash' => ['required'],
            'token' => ['required'],
        ]);

        $customer = Customer::find($request->id);

        if (!$customer) {
            Log::error('User not found for email verification', ['id' => $request->id]);
            return redirect()->route('login')->withErrors(['error' => 'Invalid verification link.']);
        }

        if ($customer->hasVerifiedEmail()) {
            Log::info('Email already verified for user: ' . $customer->email);
            Auth::guard('customer')->login($customer);
            $request->session()->regenerate();
            return redirect()->route('profile')->with('success', 'Your email is already verified. Welcome to ' . config('app.name') . '!');
        }

        if (sha1($customer->email) !== $request->hash) {
            Log::error('Email hash mismatch for verification', [
                'email' => $customer->email,
                'provided_hash' => $request->hash,
            ]);
            return redirect()->route('login')->withErrors(['error' => 'Invalid verification link.']);
        }

        // Verify token
        $resetToken = DB::table('password_reset_tokens')
            ->where('email', $customer->email)
            ->first();

        if (!$resetToken || !Hash::check($request->token, $resetToken->token)) {
            Log::error('Invalid or expired verification token', ['email' => $customer->email]);
            return redirect()->route('login')->withErrors(['error' => 'Invalid or expired verification token.']);
        }

        try {
            // Mark email as verified
            $customer->email_verified_at = now();
            $customer->save();

            // Delete verification token
            DB::table('password_reset_tokens')
                ->where('email', $customer->email)
                ->delete();

            Log::info('Verification token deleted for email: ' . $customer->email);

            // Send welcome email
            $template = EmailTemplate::where('name', 'Welcome Email')
                ->where('status', 1)
                ->first();

            if (!$template) {
                Log::error('Welcome email template not found for user: ' . $customer->email);
            } else {
                $data = [
                    'user_name' => $customer->first_name . ' ' . $customer->last_name,
                    'user_email' => $customer->email,
                    'site_name' => config('app.name'),
                    'site_url' => config('app.url'),
                ];

                $subject = $this->replaceTemplateVariables($template->subject, $data);
                $body = $this->replaceTemplateVariables($template->body, $data);

                Mail::html($body, function ($message) use ($customer, $subject) {
                    $message->to($customer->email)
                            ->subject($subject)
                            ->from(config('mail.from.address'), config('mail.from.name'));
                });
                Log::info('Welcome email sent to: ' . $customer->email);
            }

            // Log in the user
            Auth::guard('customer')->login($customer);
            $request->session()->regenerate();

            Log::info('Email verified and user logged in: ' . $customer->email);

            return redirect()->route('profile')->with('success', 'Email verified successfully! Welcome to ' . config('app.name') . '!');
        } catch (\Exception $e) {
            Log::error('Email verification failed: ' . $e->getMessage(), ['email' => $customer->email]);
            return redirect()->route('login')->withErrors(['error' => 'Failed to verify email. Please try again.']);
        }
    }


    public function forgotPassword(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate(['email' => ['required', 'email']]);

            $status = Password::broker('customers')->sendResetLink(
                $request->only('email'),
                function ($user, $token) {
                    $template = EmailTemplate::where('name', 'Forgot Password')
                        ->where('status', 1)
                        ->first();

                    if (!$template) {
                        Log::error('Forgot password template not found for user: ' . $user->email);
                        return;
                    }

                    $data = [
                        'token' => $token,
                        'site_name' => config('app.name'),
                        'site_url' => config('app.url'),
                        'user_name' => $user->first_name . ' ' . $user->last_name,
                        'user_email' => $user->email,
                        'reset_link' => config('app.url') . '/reset-password?token=' . $token . '&email=' . urlencode($user->email),
                    ];

                    $subject = $this->replaceTemplateVariables($template->subject, $data);
                    $body = $this->replaceTemplateVariables($template->body, $data);

                    Log::info('Attempting to send email to: ' . $user->email . ' with subject: ' . $subject);
                    Log::debug('Email reset URL: ' . $data['reset_link']);

                    try {
                        Mail::html($body, function ($message) use ($user, $subject) {
                            $message->to($user->email)
                                    ->subject($subject)
                                    ->from(config('mail.from.address'), config('mail.from.name'));
                        });
                        Log::info('Email sent successfully to: ' . $user->email);
                    } catch (\Exception $e) {
                        Log::error('Failed to send email to ' . $user->email . ': ' . $e->getMessage());
                    }
                }
            );

            Log::info('Password reset link status: ' . $status);

            return $status === Password::RESET_LINK_SENT
                ? back()->with('success', 'Password reset link sent to your email!')
                : back()->withErrors(['email' => __($status)]);
        }

        return view('store.pages.account.forgot_password');
    }

    public function showResetForm(Request $request)
    {
        $token = $request->query('token');
        $email = $request->query('email');

        if (!$token || !$email) {
            Log::error('Missing token or email in reset password URL', [
                'token' => $token,
                'email' => $email,
            ]);
            return redirect()->route('forgot_password')->withErrors(['error' => 'Invalid or missing reset token/email.']);
        }

        // Verify user exists
        $user = Customer::where('email', $email)->first();
        if (!$user) {
            Log::error('User not found for reset form', ['email' => $email]);
            return redirect()->route('forgot_password')->withErrors(['error' => 'No account found for this email.']);
        }

        // Verify token exists
        $resetToken = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->first();

        if (!$resetToken) {
            Log::error('No reset token found for email', ['email' => $email]);
            return redirect()->route('forgot_password')->withErrors(['error' => 'Invalid or expired reset token.']);
        }

        return view('store.pages.account.reset_password', [
            'token' => $token,
            'email' => $email,
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        Log::info('Attempting password reset', [
            'email' => $request->email,
            'token' => $request->token,
        ]);

        // Find user
        $user = Customer::where('email', $request->email)->first();
        if (!$user) {
            Log::error('User not found for email', ['email' => $request->email]);
            return back()->withErrors(['email' => 'No account found for this email.']);
        }

        // Verify token
        $resetToken = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$resetToken) {
            Log::error('No reset token found for email', ['email' => $request->email]);
            return back()->withErrors(['email' => 'Invalid or expired reset token.']);
        }

        // Debug token comparison
        $isValidToken = Hash::check($request->token, $resetToken->token);
        Log::info('Token validation', [
            'email' => $request->email,
            'provided_token' => $request->token,
            'stored_token' => $resetToken->token,
            'is_valid' => $isValidToken,
        ]);

        if (!$isValidToken) {
            Log::error('Token mismatch', [
                'email' => $request->email,
                'provided_token' => $request->token,
                'stored_token' => $resetToken->token,
            ]);
            return back()->withErrors(['email' => 'Invalid or expired reset token.']);
        }

        try {
            // Update user password
            $user->forceFill([
                'password' => Hash::make($request->password),
            ])->setRememberToken(Str::random(60));

            Log::info('Before saving user', [
                'email' => $user->email,
                'user_id' => $user->id,
            ]);

            $user->save();

            Log::info('Password reset successful for user: ' . $user->email);

            // Delete the reset token
            DB::table('password_reset_tokens')
                ->where('email', $user->email)
                ->delete();

            return redirect()->route('login')->with('success', 'Password reset successfully! Please login with your new password.');
        } catch (\Exception $e) {
            Log::error('Password reset failed: ' . $e->getMessage(), [
                'email' => $user->email,
            ]);
            return back()->withErrors(['email' => 'Failed to reset password. Please try again.']);
        }
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
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:customers,email,'.$customer->id],
            'contact_no' => ['nullable', 'string', 'max:20'],
            'alternative_contact_no' => ['nullable', 'string', 'max:20'],
        ]);

        $customer->update($validated);

        return redirect()->route('profile')->with('success', 'Profile updated successfully');
    }

    public function changePassword()
    {
        $customer = Auth::guard('customer')->user();
        if (!$customer) {
            return redirect()->route('login')->with('error', 'Please log in to change your password.');
        }

        return view('store.pages.account.change_password');
    }

    public function updatePassword(Request $request)
    {
        $customer = Auth::guard('customer')->user();
        if (!$customer) {
            return redirect()->route('login')->with('error', 'Please log in to update your password.');
        }

        $validated = $request->validate([
            'current_password' => ['required', 'string'],
            'new_password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'
            ],
        ], [
            'new_password.regex' => 'The new password must contain at least 1 uppercase letter, 1 lowercase letter, 1 number, and 1 special character (@$!%*?&).',
            'new_password.min' => 'The new password must be at least 8 characters long.',
            'new_password.confirmed' => 'The new password confirmation does not match.',
        ]);

        if (!Hash::check($validated['current_password'], $customer->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.'])->withInput();
        }

        if (Hash::check($validated['new_password'], $customer->password)) {
            return back()->withErrors(['new_password' => 'The new password cannot be the same as the current password.'])->withInput();
        }

        $customer->update([
            'password' => Hash::make($validated['new_password']),
        ]);

        return redirect()->route('profile')->with('success', 'Password updated successfully');
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
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string'],
            'city' => ['nullable', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'pincode' => ['nullable', 'string', 'max:20'],
            'country' => ['nullable', 'string', 'max:100'],
            'is_default' => ['sometimes', 'boolean'],
        ]);

        $isDefault = $request->boolean('is_default', false);
        Log::info('is_default value during store: ' . ($isDefault ? 'true' : 'false'));

        $address = $customer->addresses()->create([
            'name' => $validated['name'],
            'address' => $validated['address'],
            'city' => $validated['city'],
            'state' => $validated['state'],
            'pincode' => $validated['pincode'],
            'country' => $validated['country'],
            'is_default' => $isDefault,
        ]);

        if ($isDefault) {
            $customer->addresses()->where('id', '!=', $address->id)->update(['is_default' => false]);
            Log::info('Updated other addresses to is_default = false for customer ID: ' . $customer->id);
        }

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
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string'],
            'city' => ['nullable', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'pincode' => ['nullable', 'string', 'max:20'],
            'country' => ['nullable', 'string', 'max:100'],
            'is_default' => ['sometimes', 'boolean'],
        ]);

        $isDefault = $request->boolean('is_default', false);
        Log::info('is_default value during update for address ID ' . $id . ': ' . ($isDefault ? 'true' : 'false'));

        $address->update([
            'name' => $validated['name'],
            'address' => $validated['address'],
            'city' => $validated['city'],
            'state' => $validated['state'],
            'pincode' => $validated['pincode'],
            'country' => $validated['country'],
            'is_default' => $isDefault,
        ]);

        if ($isDefault) {
            $customer->addresses()->where('id', '!=', $id)->update(['is_default' => false]);
            Log::info('Updated other addresses to is_default = false for customer ID: ' . $customer->id);
        }

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

    public function logout(Request $request)
    {
        Auth::guard('customer')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home')->with('success', 'You have been logged out.');
    }

    private function replaceTemplateVariables($content, $data)
    {
        foreach ($data as $key => $value) {
            $content = str_replace('{{' . $key . '}}', $value, $content);
        }
        return $content;
    }
}
