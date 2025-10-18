<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            try {
                $testimonials = Testimonial::select('id', 'name', 'designation', 'image', 'message', 'rating', 'status', 'created_at')->get();

                return DataTables::of($testimonials)
                    ->addColumn('checkbox', function($row) {
                        return '<input type="checkbox" class="select-item" value="'.$row->id.'">';
                    })
                    ->addColumn('image', function($row) {
                        return $row->image ?
                            '<img src="/storage/' . $row->image . '" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">' :
                            '<span class="text-muted">No Image</span>';
                    })
                    ->addColumn('name', function($row) {
                        return $row->name . '<br><small class="text-muted">' . ($row->designation ?? 'N/A') . '</small>';
                    })
                    ->addColumn('rating', function($row) {
                        return str_repeat('⭐', $row->rating);
                    })
                    ->addColumn('status', function($row) {
                        return $row->status ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>';
                    })
                    ->addColumn('created_at', function($row) {
                        return $row->created_at ? $row->created_at->format('Y-m-d H:i:s') : 'N/A';
                    })
                    ->addColumn('action', function($row) {
                        return '
                            <a href="'.route('admin.testimonials.show', $row->id).'" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                            <a href="'.route('admin.testimonials.edit', $row->id).'" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                            <form action="'.route('admin.testimonials.destroy', $row->id).'" method="POST" class="d-inline delete-form">
                                '.csrf_field().'
                                '.method_field('DELETE').'
                                <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        ';
                    })
                    ->rawColumns(['checkbox', 'image', 'name', 'rating', 'status', 'action'])
                    ->make(true);
            } catch (\Exception $e) {
                \Log::error('DataTable Error: ' . $e->getMessage());
                return response()->json(['error' => 'Failed to load testimonials'], 500);
            }
        }
        return view('admin.testimonials.index');
    }

    public function create()
    {
        return view('admin.testimonials.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'nullable|string|max:255',
            'message' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:0,1'
        ]);

        $validated['status'] = $request->status == '1';

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('testimonials', 'public');
        }

        Testimonial::create($validated);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial created successfully');
    }

    public function show(Testimonial $testimonial)
    {
        return view('admin.testimonials.show', compact('testimonial'));
    }

    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'nullable|string|max:255',
            'message' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:0,1'
        ]);

        $validated['status'] = $request->status == '1';

        if ($request->hasFile('image')) {
            if ($testimonial->image) {
                Storage::disk('public')->delete($testimonial->image);
            }
            $validated['image'] = $request->file('image')->store('testimonials', 'public');
        }

        $testimonial->update($validated);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial updated successfully');
    }

    public function destroy(Testimonial $testimonial)
    {
        if ($testimonial->image) {
            Storage::disk('public')->delete($testimonial->image);
        }
        $testimonial->delete();
        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial deleted successfully');
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:testimonials,id'
        ]);

        foreach ($request->ids as $id) {
            $testimonial = Testimonial::find($id);
            if ($testimonial && $testimonial->image) {
                Storage::disk('public')->delete($testimonial->image);
            }
        }

        Testimonial::whereIn('id', $request->ids)->delete();
        return response()->json(['success' => 'Testimonials deleted successfully']);
    }
}
