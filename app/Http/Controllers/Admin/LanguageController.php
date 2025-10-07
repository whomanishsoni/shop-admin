<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LanguageController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $languages = Language::select('*');
            return DataTables::of($languages)
                ->addColumn('checkbox', function($row) {
                    return '<input type="checkbox" class="select-item" value="'.$row->id.'">';
                })
                ->addColumn('status', function($row) {
                    return $row->status ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>';
                })
                ->addColumn('action', function($row) {
                    return '
                        <a href="'.route('admin.languages.edit', $row->id).'" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                        <form action="'.route('admin.languages.destroy', $row->id).'" method="POST" class="d-inline delete-form">
                            '.csrf_field().'
                            '.method_field('DELETE').'
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    ';
                })
                ->rawColumns(['checkbox', 'status', 'action'])
                ->make(true);
        }
        return view('admin.languages.index');
    }

    public function create()
    {
        return view('admin.languages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:languages,code|max:10',
            'locale' => 'required|string|max:10',
            'direction' => 'required|in:ltr,rtl',
            'status' => 'boolean'
        ]);

        Language::create($validated);

        return redirect()->route('admin.languages.index')->with('success', 'Language created successfully');
    }

    public function show(Language $language)
    {
        return view('admin.languages.show', compact('language'));
    }

    public function edit(Language $language)
    {
        return view('admin.languages.edit', compact('language'));
    }

    public function update(Request $request, Language $language)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:languages,code,'.$language->id,
            'locale' => 'required|string|max:10',
            'direction' => 'required|in:ltr,rtl',
            'status' => 'boolean'
        ]);

        $validated['status'] = $request->has('status') ? true : false;

        $language->update($validated);

        return redirect()->route('admin.languages.index')->with('success', 'Language updated successfully');
    }

    public function destroy(Language $language)
    {
        $language->delete();
        return redirect()->route('admin.languages.index')->with('success', 'Language deleted successfully');
    }

    public function bulkDelete(Request $request)
    {
        Language::whereIn('id', $request->ids)->delete();
        return response()->json(['success' => 'Languages deleted successfully']);
    }
}
