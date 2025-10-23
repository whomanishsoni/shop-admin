<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;

class SettingController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $settings = Setting::select('*');
            return DataTables::of($settings)
                ->addColumn('checkbox', function($row) {
                    return '<input type="checkbox" class="select-item" value="'.$row->id.'">';
                })
                ->addColumn('value_display', function($row) {
                    if (in_array($row->type, ['file', 'image']) && $row->value) {
                        return '<img src="/storage/'.$row->value.'" width="50" height="50" style="object-fit: cover;">';
                    }
                    return strlen($row->value) > 50 ? substr($row->value, 0, 50).'...' : $row->value;
                })
                ->addColumn('action', function($row) {
                    return '
                        <a href="'.route('admin.settings.edit', $row->id).'" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                        <form action="'.route('admin.settings.destroy', $row->id).'" method="POST" class="d-inline delete-form">
                            '.csrf_field().'
                            '.method_field('DELETE').'
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    ';
                })
                ->rawColumns(['checkbox', 'value_display', 'action'])
                ->make(true);
        }

        $settings = Setting::pluck('value', 'key')->toArray();
        return view('admin.settings.index', compact('settings'));
    }

    public function create()
    {
        return view('admin.settings.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'key' => 'required|string|unique:settings,key',
            'value' => 'nullable|string',
            'type' => 'required|in:text,textarea,number,boolean,file,image'
        ]);

        if ($request->hasFile('value')) {
            $validated['value'] = $request->file('value')->store('settings', 'public');
        }

        Setting::create($validated);

        return redirect()->route('admin.settings.index')->with('success', 'Setting created successfully');
    }

    public function update(Request $request, Setting $setting)
    {
        $validated = $request->validate([
            'key' => 'required|string|unique:settings,key,'.$setting->id,
            'value' => 'nullable|string',
            'type' => 'required|in:text,textarea,number,boolean,file,image'
        ]);

        if ($request->hasFile('value')) {
            $validated['value'] = $request->file('value')->store('settings', 'public');
        }

        $setting->update($validated);

        return redirect()->route('admin.settings.index')->with('success', 'Setting updated successfully');
    }

    public function bulkUpdate(Request $request)
    {
        $fileFields = ['site_logo', 'site_favicon', 'footer_logo'];
        $mailFields = ['mail_host', 'mail_port', 'mail_username', 'mail_password', 'mail_encryption', 'mail_from_address', 'mail_from_name'];

        try {
            foreach ($request->except(['_token']) as $key => $value) {
                if ($request->hasFile($key)) {
                    $value = $request->file($key)->store('settings', 'public');
                }

                if (in_array($key, $mailFields)) {
                    $this->updateEnvVariable(strtoupper($key), $value);
                    Setting::updateOrCreate(['key' => $key], ['value' => $value, 'type' => 'text']);
                } else {
                    Setting::updateOrCreate(['key' => $key], [
                        'value' => $value,
                        'type' => in_array($key, $fileFields) ? 'image' : 'text'
                    ]);
                }
            }

            // Always set MAIL_MAILER to smtp when updating mail settings
            if ($request->hasAny($mailFields)) {
                $this->updateEnvVariable('MAIL_MAILER', 'smtp');
                \Artisan::call('config:clear');
                \Artisan::call('config:cache');
            }

            return redirect()->route('admin.settings.index')->with('success', 'Settings updated successfully');
        } catch (\Exception $e) {
            \Log::error('Bulk update failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update settings: ' . $e->getMessage());
        }
    }

    public function testMail(Request $request)
    {
        $validated = $request->validate([
            'test_email' => 'required|email'
        ]);

        try {
            Mail::raw('This is a test email to verify your mail settings.', function ($message) use ($validated) {
                $message->to($validated['test_email'])
                        ->subject('Test Email from ' . config('app.name'))
                        ->from(config('mail.from.address'), config('mail.from.name'));
            });
            \Log::info('Test email sent successfully to ' . $validated['test_email']);
            return response()->json(['success' => true, 'message' => 'Test email sent successfully!']);
        } catch (\Exception $e) {
            \Log::error('Failed to send test email: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to send test email: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Update environment variable in .env file
     */
    private function updateEnvVariable($key, $value)
    {
        $path = base_path('.env');

        if (!file_exists($path)) {
            return;
        }

        $envContent = file_get_contents($path);

        // Escape special characters in value
        $value = str_replace('"', '\"', $value);

        // Check if key exists
        if (preg_match("/^{$key}=.*/m", $envContent)) {
            // Update existing key
            $envContent = preg_replace(
                "/^{$key}=.*/m",
                "{$key}=\"{$value}\"",
                $envContent
            );
        } else {
            // Add new key
            $envContent .= "\n{$key}=\"{$value}\"";
        }

        file_put_contents($path, $envContent);
    }
}
