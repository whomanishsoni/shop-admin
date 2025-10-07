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
            $reviews = ProductReview::with(['product', 'customer'])->select('*');
            return DataTables::of($reviews)
                ->addColumn('checkbox', function($row) {
                    return '<input type="checkbox" class="select-item" value="'.$row->id.'">';
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
                ->addColumn('approved', function($row) {
                    return $row->approved ? '<span class="badge bg-success">Approved</span>' : '<span class="badge bg-warning">Pending</span>';
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
                ->rawColumns(['checkbox', 'rating', 'approved', 'action'])
                ->make(true);
        }
        return view('admin.product-reviews.index');
    }

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
            'approved' => 'boolean'
        ]);

        $validated['approved'] = $request->has('approved') ? true : false;

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
}
