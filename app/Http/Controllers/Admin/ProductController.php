<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Brand;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeValue;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $products = Product::with(['category', 'subcategory', 'brand'])->select('*');
            return DataTables::of($products)
                ->addColumn('checkbox', function($row) {
                    return '<input type="checkbox" class="select-item" value="'.$row->id.'">';
                })
                ->addColumn('image', function($row) {
                    $primary = $row->images()->where('is_primary', 1)->first();
                    return $primary ? '<img src="'.asset('storage/'.$primary->image).'" width="50" height="50" class="img-thumbnail">' : 'No Image';
                })
                ->addColumn('category', function($row) {
                    return $row->category ? $row->category->name : 'N/A';
                })
                ->addColumn('subcategory', function($row) {
                    return $row->subcategory ? $row->subcategory->name : 'N/A';
                })
                ->addColumn('brand', function($row) {
                    return $row->brand ? $row->brand->name : 'N/A';
                })
                ->addColumn('price', function($row) {
                    return '$'.number_format($row->price, 2);
                })
                ->addColumn('status', function($row) {
                    return $row->status == 'active' ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>';
                })
                ->addColumn('action', function($row) {
                    return '
                        <a href="'.route('admin.products.show', $row->id).'" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                        <a href="'.route('admin.products.edit', $row->id).'" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                        <form action="'.route('admin.products.destroy', $row->id).'" method="POST" class="d-inline delete-form">
                            '.csrf_field().'
                            '.method_field('DELETE').'
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    ';
                })
                ->rawColumns(['checkbox', 'image', 'status', 'action'])
                ->make(true);
        }
        return view('admin.products.index');
    }

    public function create()
    {
        $categories = Category::where('status', 1)->get();
        $brands = Brand::where('status', 1)->get();
        $attributes = ProductAttribute::where('status', 1)->get();
        return view('admin.products.create', compact('categories', 'brands', 'attributes'));
    }

    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:products,slug',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lte:price',
            'stock' => 'nullable|integer|min:0',
            'sku' => 'nullable|string|unique:products,sku',
            'category_id' => 'nullable|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'status' => 'required|in:active,inactive',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string|max:255',
            'images' => 'nullable|array',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'attributes' => 'nullable|array',
            'attributes.*' => 'nullable', // Allow array or string
            'attributes.*.*' => 'nullable|string', // Validate individual values in arrays
        ]);

        // Generate slug if not provided
        $validated['slug'] = $validated['slug'] ?? Str::slug($request->name);

        // Generate unique SKU if not provided
        if (empty($validated['sku'])) {
            do {
                $validated['sku'] = 'PROD-' . strtoupper(Str::random(8));
            } while (Product::where('sku', $validated['sku'])->exists());
        }

        // Set default stock to 1 if not provided
        $validated['stock'] = $validated['stock'] ?? 1;

        // Create the product
        $product = Product::create($validated);

        // Handle image uploads
        if ($request->hasFile('images')) {
            $product->images()->update(['is_primary' => false]);
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products', 'public');
                $product->images()->create([
                    'image' => $path,
                    'sort_order' => $index,
                    'is_primary' => $index === 0
                ]);
            }
        }

        // Handle attributes
        if ($request->has('attributes')) {
            foreach ($request->input('attributes') as $attr_id => $values) {
                // Validate that attribute_id exists
                if (!ProductAttribute::where('id', $attr_id)->exists()) {
                    continue;
                }

                if (is_array($values) && !empty($values)) {
                    // Filter out empty strings but preserve valid values like '0'
                    $filteredValues = array_filter($values, fn($value) => is_string($value) && $value !== '');
                    if (!empty($filteredValues)) {
                        try {
                            ProductAttributeValue::create([
                                'product_id' => $product->id,
                                'attribute_id' => $attr_id,
                                'value' => $filteredValues, // Store as array (cast to JSON by model)
                            ]);
                        } catch (\Exception $e) {
                            // Silently handle errors to prevent form submission failure
                        }
                    }
                } elseif (is_string($values) && $values !== '') {
                    // Store single value
                    try {
                        ProductAttributeValue::create([
                            'product_id' => $product->id,
                            'attribute_id' => $attr_id,
                            'value' => $values,
                        ]);
                    } catch (\Exception $e) {
                        // Silently handle errors to prevent form submission failure
                    }
                }
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully');
    }

    public function show(Product $product)
    {
        $product->load(['category', 'subcategory', 'brand', 'images', 'reviews', 'attributeValues.attribute']);
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::where('status', 1)->get();
        $brands = Brand::where('status', 1)->get();
        $subcategories = Subcategory::where('category_id', $product->category_id)->where('status', 1)->get();
        $attributes = ProductAttribute::where('status', 1)->get();
        $attributeValues = $product->attributeValues()->get()->keyBy('attribute_id')->map(function ($item) {
            // Return value as-is since it's already cast to array by the model
            return $item->value;
        })->toArray();

        return view('admin.products.edit', compact('product', 'categories', 'brands', 'subcategories', 'attributes', 'attributeValues'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:products,slug,' . $product->id,
            'description' => 'nullable|string',
            'short_description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lte:price',
            'stock' => 'nullable|integer|min:0',
            'sku' => 'nullable|string|unique:products,sku,' . $product->id,
            'category_id' => 'nullable|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'status' => 'required|in:active,inactive',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string|max:255',
            'images' => 'nullable|array',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'delete_images' => 'nullable|array',
            'delete_images.*' => 'nullable|exists:product_images,id',
            'attributes' => 'nullable|array',
            'attributes.*' => 'nullable', // Allow array or string
            'attributes.*.*' => 'nullable|string', // Validate individual values in arrays
        ]);

        // Generate slug if not provided
        $validated['slug'] = $validated['slug'] ?? Str::slug($request->name);

        // Generate unique SKU if not provided
        if (empty($validated['sku'])) {
            do {
                $validated['sku'] = 'PROD-' . strtoupper(Str::random(8));
            } while (Product::where('sku', $validated['sku'])->exists());
        }

        // Set default stock to 1 if not provided
        $validated['stock'] = $validated['stock'] ?? 1;

        // Update the product
        $product->update($validated);

        // Handle image deletions
        if ($request->has('delete_images')) {
            $wasPrimaryDeleted = $product->images()->whereIn('id', $request->delete_images)->where('is_primary', true)->exists();
            $product->images()->whereIn('id', $request->delete_images)->delete();

            // If primary image was deleted, set the first remaining image as primary
            if ($wasPrimaryDeleted) {
                $firstImage = $product->images()->orderBy('sort_order')->first();
                if ($firstImage) {
                    $firstImage->update(['is_primary' => true]);
                }
            }
        }

        // Handle image uploads
        if ($request->hasFile('images')) {
            $existingCount = $product->images()->count();
            $hasPrimary = $product->images()->where('is_primary', true)->exists();

            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products', 'public');
                $product->images()->create([
                    'image' => $path,
                    'sort_order' => $existingCount + $index,
                    'is_primary' => !$hasPrimary && $index === 0 // Set first uploaded image as primary if no primary exists
                ]);
            }
        }

        // Handle attributes
        $product->attributeValues()->delete();
        if ($request->has('attributes')) {
            foreach ($request->input('attributes') as $attr_id => $values) {
                // Validate that attribute_id exists
                if (!ProductAttribute::where('id', $attr_id)->exists()) {
                    continue;
                }

                if (is_array($values) && !empty($values)) {
                    // Filter out empty strings but preserve valid values like '0'
                    $filteredValues = array_filter($values, fn($value) => is_string($value) && $value !== '');
                    if (!empty($filteredValues)) {
                        try {
                            ProductAttributeValue::create([
                                'product_id' => $product->id,
                                'attribute_id' => $attr_id,
                                'value' => $filteredValues, // Store as array (cast to JSON by model)
                            ]);
                        } catch (\Exception $e) {
                            // Silently handle errors to prevent form submission failure
                        }
                    }
                } elseif (is_string($values) && $values !== '') {
                    // Store single value
                    try {
                        ProductAttributeValue::create([
                            'product_id' => $product->id,
                            'attribute_id' => $attr_id,
                            'value' => $values,
                        ]);
                    } catch (\Exception $e) {
                        // Silently handle errors to prevent form submission failure
                    }
                }
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully');
    }

    public function destroy(Product $product)
    {
        $product->images()->delete();
        $product->attributeValues()->delete();
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully');
    }

    public function bulkDelete(Request $request)
    {
        $products = Product::whereIn('id', $request->ids);
        foreach ($products->get() as $product) {
            $product->images()->delete();
            $product->attributeValues()->delete();
        }
        $products->delete();
        return response()->json(['success' => 'Products deleted successfully']);
    }

    public function getSubcategories($category_id)
    {
        $subcategories = Subcategory::where('category_id', $category_id)->get(['id', 'name']);
        return response()->json($subcategories);
    }
}
