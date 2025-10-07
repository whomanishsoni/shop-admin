<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
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

    public function show(Setting $setting)
    {
        return view('admin.settings.show', compact('setting'));
    }

    public function edit(Setting $setting)
    {
        return view('admin.settings.edit', compact('setting'));
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
        
        foreach ($request->except(['_token']) as $key => $value) {
            if ($request->hasFile($key)) {
                $value = $request->file($key)->store('settings', 'public');
            }
            
            Setting::updateOrCreate(
                ['key' => $key],
                [
                    'value' => $value,
                    'type' => in_array($key, $fileFields) ? 'image' : 'text'
                ]
            );
        }

        return redirect()->route('admin.settings.index')->with('success', 'Settings updated successfully');
    }

    public function destroy(Setting $setting)
    {
        $setting->delete();
        return redirect()->route('admin.settings.index')->with('success', 'Setting deleted successfully');
    }

    public function bulkDelete(Request $request)
    {
        Setting::whereIn('id', $request->ids)->delete();
        return response()->json(['success' => 'Settings deleted successfully']);
    }
}
