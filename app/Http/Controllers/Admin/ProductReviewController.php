<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductReview;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProductReviewController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            try {
                $reviews = ProductReview::with(['product', 'customer'])
                    ->select('id', 'product_id', 'customer_id', 'rating', 'comment', 'created_at')
                    ->get();

                return DataTables::of($reviews)
                    ->addColumn('checkbox', function($row) {
                        return '<input type="checkbox" class="select-item" value="'.$row->id.'">';
                    })
                    ->addColumn('image', function($row) {
                        if ($row->product && $row->product->images) {
                            $primary = $row->product->images()->where('is_primary', 1)->first();
                            return $primary ? '<img src="/storage/'.$primary->image.'" style="width: 60px; height: 60px; object-fit: cover; border: 2px solid #e9ecef; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">' : '<div style="width: 60px; height: 60px; border: 2px dashed #dee2e6; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #6c757d; font-size: 10px; font-weight: 500;">No Image</div>';
                        }
                        return '<div style="width: 60px; height: 60px; border: 2px dashed #dee2e6; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #6c757d; font-size: 10px; font-weight: 500;">No Image</div>';
                    })
                    ->addColumn('product', function($row) {
                        return $row->product ? $row->product->name : 'N/A';
                    })
                    ->addColumn('customer', function($row) {
                        return $row->customer ? $row->customer->name : 'N/A';
                    })
                    ->addColumn('rating', function($row) {
                        return str_repeat('⭐', $row->rating);
                    })
                    ->addColumn('comment', function($row) {
                        return $row->comment ? $row->comment : 'N/A';
                    })
                    ->addColumn('created_at', function($row) {
                        return $row->created_at ? $row->created_at->format('Y-m-d H:i:s') : 'N/A';
                    })
                    ->addColumn('action', function($row) {
                        return '
                            <a href="'.route('admin.product-reviews.show', $row->id).'" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                            <a href="'.route('admin.product-reviews.edit', $row->id).'" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                            <form action="'.route('admin.product-reviews.destroy', $row->id).'" method="POST" class="d-inline delete-form">
                                '.csrf_field().'
                                '.method_field('DELETE').'
                                <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        ';
                    })
                    ->rawColumns(['checkbox', 'image', 'rating', 'action'])
                    ->make(true);
            } catch (\Exception $e) {
                \Log::error('DataTable Error: ' . $e->getMessage());
                return response()->json(['error' => 'Failed to load reviews'], 500);
            }
        }
        return view('admin.product-reviews.index');
    }

    // [Rest of the methods remain unchanged]
    public function create()
    {
        $products = Product::where('status', 'active')->get();
        $customers = Customer::all();
        return view('admin.product-reviews.create', compact('products', 'customers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'customer_id' => 'required|exists:customers,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
            'approved' => 'boolean'
        ]);

        ProductReview::create($validated);

        return redirect()->route('admin.product-reviews.index')->with('success', 'Product Review created successfully');
    }

    public function show(ProductReview $productReview)
    {
        $productReview->load(['product', 'customer']);
        return view('admin.product-reviews.show', compact('productReview'));
    }

    public function edit(ProductReview $productReview)
    {
        $products = Product::where('status', 'active')->get();
        $customers = Customer::all();
        return view('admin.product-reviews.edit', compact('productReview', 'products', 'customers'));
    }

    public function update(Request $request, ProductReview $productReview)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'customer_id' => 'required|exists:customers,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
            'approved' => 'required|boolean' // Ensure validated as boolean
        ]);

        $validated['approved'] = (bool) $request->input('approved', false); // Convert 1/0 to true/false

        $productReview->update($validated);

        return redirect()->route('admin.product-reviews.index')->with('success', 'Product Review updated successfully');
    }

    public function destroy(ProductReview $productReview)
    {
        $productReview->delete();
        return redirect()->route('admin.product-reviews.index')->with('success', 'Product Review deleted successfully');
    }

    public function bulkDelete(Request $request)
    {
        ProductReview::whereIn('id', $request->ids)->delete();
        return response()->json(['success' => 'Product Reviews deleted successfully']);
    }

    public function approve(ProductReview $productReview)
    {
        $productReview->update(['approved' => true]);
        return redirect()->back()->with('success', 'Review approved successfully.');
    }
}
