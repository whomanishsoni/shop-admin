<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SliderController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $sliders = Slider::select('*');
            return DataTables::of($sliders)
                ->addColumn('checkbox', function($row) {
                    return '<input type="checkbox" class="select-item" value="'.$row->id.'">';
                })
                ->addColumn('image', function($row) {
                    return $row->image ? '<img src="/storage/'.$row->image.'" width="80" style="border-radius: 5px;">' : 'No Image';
                })
                ->addColumn('title', function($row) {
                    return $row->title;
                })
                ->addColumn('status', function($row) {
                    return $row->status ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>';
                })
                ->addColumn('action', function($row) {
                    return '
                        <a href="'.route('admin.sliders.edit', $row->id).'" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                        <form action="'.route('admin.sliders.destroy', $row->id).'" method="POST" class="d-inline delete-form">
                            '.csrf_field().'
                            '.method_field('DELETE').'
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    ';
                })
                ->rawColumns(['checkbox', 'image', 'title', 'status', 'action'])
                ->make(true);
        }
        return view('admin.sliders.index');
    }

    public function create()
    {
        return view('admin.sliders.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'link' => 'nullable|url',
            'order' => 'nullable|integer',
            'status' => 'boolean'
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('sliders', 'public');
        }

        Slider::create($validated);

        return redirect()->route('admin.sliders.index')->with('success', 'Slider created successfully');
    }

    public function show(Slider $slider)
    {
        return view('admin.sliders.show', compact('slider'));
    }

    public function edit(Slider $slider)
    {
        return view('admin.sliders.edit', compact('slider'));
    }

    public function update(Request $request, Slider $slider)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'link' => 'nullable|url',
            'order' => 'nullable|integer',
            'status' => 'boolean'
        ]);

        $validated['status'] = $request->has('status') ? true : false;

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('sliders', 'public');
        }

        $slider->update($validated);

        return redirect()->route('admin.sliders.index')->with('success', 'Slider updated successfully');
    }

    public function destroy(Slider $slider)
    {
        $slider->delete();
        return redirect()->route('admin.sliders.index')->with('success', 'Slider deleted successfully');
    }

    public function bulkDelete(Request $request)
    {
        Slider::whereIn('id', $request->ids)->delete();
        return response()->json(['success' => 'Sliders deleted successfully']);
    }
}
