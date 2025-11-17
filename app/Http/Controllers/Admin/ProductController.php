<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Brand;
use App\Models\Collection;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeValue;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    use ImageProcessable;
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $products = Product::with(['category', 'subcategories', 'brand', 'collections'])->select('*');
            return DataTables::of($products)
                ->addColumn('checkbox', function($row) {
                    return '<input type="checkbox" class="select-item" value="'.$row->id.'">';
                })
                ->addColumn('image', function($row) {
                    $primary = $row->images()->where('is_primary', 1)->first();
                    return $primary ? '<img src="/storage/'.$primary->image.'" style="width: 60px; height: 60px; object-fit: cover; border: 2px solid #e9ecef; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">' : '<div style="width: 60px; height: 60px; border: 2px dashed #dee2e6; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #6c757d; font-size: 10px; font-weight: 500;">No Image</div>';
                })
                ->addColumn('category', function($row) {
                    return $row->category ? $row->category->name : 'N/A';
                })
                ->addColumn('subcategory', function($row) {
                    $subcategories = $row->subcategories->pluck('name')->toArray();
                    return !empty($subcategories) ? implode(', ', $subcategories) : 'N/A';
                })
                ->addColumn('brand', function($row) {
                    return $row->brand ? $row->brand->name : 'N/A';
                })
                ->addColumn('collections', function($row) {
                    $collections = $row->collections->pluck('name')->toArray();
                    return !empty($collections) ? implode(', ', $collections) : 'N/A';
                })
                ->addColumn('price', function($row) {
                    return '$'.number_format($row->price, 2);
                })
                ->addColumn('status', function($row) {
                    return $row->status == 'active' ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>';
                })
                ->addColumn('featured', function($row) {
                    return $row->is_featured ? '<span class="badge bg-warning">Featured</span>' : '<span class="badge bg-secondary">Not Featured</span>';
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
                ->rawColumns(['checkbox', 'image', 'status', 'featured', 'action'])
                ->make(true);
        }
        return view('admin.products.index');
    }

    public function create()
    {
        $categories = Category::where('status', 1)->get();
        $brands = Brand::where('status', 1)->get();
        $collections = Collection::where('status', 1)->get();
        $attributes = ProductAttribute::where('status', 1)->get();
        return view('admin.products.create', compact('categories', 'brands', 'collections', 'attributes'));
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
            'subcategories' => 'nullable|array',
            'subcategories.*' => 'exists:subcategories,id',
            'collections' => 'nullable|array',
            'collections.*' => 'exists:collections,id',
            'brand_id' => 'nullable|exists:brands,id',
            'status' => 'required|in:active,inactive',
            'is_featured' => 'nullable|boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string|max:255',
            'uploaded_images' => 'nullable|string',
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

        // Convert empty sale_price to null to avoid MySQL decimal errors
        if (isset($validated['sale_price']) && $validated['sale_price'] === '') {
            $validated['sale_price'] = null;
        }

        // Handle is_featured checkbox - if not present, set to false
        $validated['is_featured'] = $request->has('is_featured') ? 1 : 0;

        // Create the product
        $product = Product::create($validated);

        // Sync subcategories
        $product->subcategories()->sync($request->input('subcategories', []));

        // Sync collections
        $product->collections()->sync($request->input('collections', []));

        // Handle uploaded images (from AJAX uploads)
        if ($request->filled('uploaded_images')) {
            $uploadedImages = json_decode($request->input('uploaded_images'), true);
            if (is_array($uploadedImages)) {
                $product->images()->update(['is_primary' => false]);
                foreach ($uploadedImages as $index => $imagePath) {
                    $product->images()->create([
                        'image' => $imagePath,
                        'sort_order' => $index,
                        'is_primary' => $index === 0
                    ]);
                }
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
        $collections = Collection::where('status', 1)->get();
        $subcategories = Subcategory::where('category_id', $product->category_id)->where('status', 1)->get();
        $selectedSubcategories = $product->subcategories->pluck('id')->toArray();
        $selectedCollections = $product->collections->pluck('id')->toArray();
        $attributes = ProductAttribute::where('status', 1)->get();
        $attributeValues = $product->attributeValues()->get()->keyBy('attribute_id')->map(function ($item) {
            // Return value as-is since it's already cast to array by the model
            return $item->value;
        })->toArray();

        return view('admin.products.edit', compact('product', 'categories', 'brands', 'collections', 'subcategories', 'selectedSubcategories', 'selectedCollections', 'attributes', 'attributeValues'));
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
            'subcategories' => 'nullable|array',
            'subcategories.*' => 'exists:subcategories,id',
            'collections' => 'nullable|array',
            'collections.*' => 'exists:collections,id',
            'brand_id' => 'nullable|exists:brands,id',
            'status' => 'required|in:active,inactive',
            'is_featured' => 'nullable|boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string|max:255',
            'uploaded_images' => 'nullable|string',
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

        // Convert empty sale_price to null to avoid MySQL decimal errors
        if (isset($validated['sale_price']) && $validated['sale_price'] === '') {
            $validated['sale_price'] = null;
        }

        // Handle is_featured checkbox - if not present, set to false
        $validated['is_featured'] = $request->has('is_featured') ? 1 : 0;

        // Update the product
        $product->update($validated);

        // Sync subcategories
        $product->subcategories()->sync($request->input('subcategories', []));

        // Sync collections
        $product->collections()->sync($request->input('collections', []));

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

        // Handle uploaded images (from AJAX uploads)
        if ($request->filled('uploaded_images')) {
            $uploadedImages = json_decode($request->input('uploaded_images'), true);
            if (is_array($uploadedImages)) {
                $existingCount = $product->images()->count();
                $hasPrimary = $product->images()->where('is_primary', true)->exists();

                foreach ($uploadedImages as $index => $imagePath) {
                    $product->images()->create([
                        'image' => $imagePath,
                        'sort_order' => $existingCount + $index,
                        'is_primary' => !$hasPrimary && $index === 0 // Set first uploaded image as primary if no primary exists
                    ]);
                }
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
        // Delete related data
        $product->images()->delete();
        $product->attributeValues()->delete();
        $product->subcategories()->detach(); // Remove pivot relationships
        $product->collections()->detach(); // Remove pivot relationships
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully');
    }

    public function bulkDelete(Request $request)
    {
        $products = Product::whereIn('id', $request->ids);
        foreach ($products->get() as $product) {
            $product->images()->delete();
            $product->attributeValues()->delete();
            $product->subcategories()->detach(); // Remove pivot relationships
            $product->collections()->detach(); // Remove pivot relationships
        }
        $products->delete();
        return response()->json(['success' => 'Products deleted successfully']);
    }

    public function getSubcategories($category_id)
    {
        $subcategories = Subcategory::where('category_id', $category_id)->get(['id', 'name']);
        return response()->json($subcategories);
    }

    /**
     * Initialize chunked upload
     */
    public function uploadChunk(Request $request)
    {
        \Log::info('Initializing chunked upload', $request->all());

        try {
            $action = $request->get('action');

            if ($action === 'initialize') {
                return $this->initializeChunkUpload($request);
            } elseif ($action === 'finalize') {
                return $this->finalizeChunkUpload($request);
            }

            return response()->json(['error' => 'Invalid action'], 400);
        } catch (\Exception $e) {
            \Log::error('Chunk upload error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Initialize chunked file upload
     */
    private function initializeChunkUpload(Request $request)
    {
        $fileId = $request->get('file_id');
        $fileName = $request->get('file_name');
        $fileSize = $request->get('file_size');
        $fileType = $request->get('file_type');

        // Store initialization data in session/cache
        $uploadData = [
            'file_name' => $fileName,
            'file_size' => $fileSize,
            'file_type' => $fileType,
            'chunks' => [],
            'uploaded_bytes' => 0,
            'status' => 'initializing'
        ];

        // Store in cache with 1 hour expiration
        \Cache::put('upload_' . $fileId, $uploadData, 3600);

        \Log::info("Initialized upload for file: {$fileName}, size: {$fileSize}");

        return response()->json([
            'success' => true,
            'file_id' => $fileId,
            'message' => 'Upload initialized'
        ]);
    }

    /**
     * Finalize chunked upload and process the file
     */
    private function finalizeChunkUpload(Request $request)
    {
        $fileId = $request->get('file_id');
        $uploadData = \Cache::get('upload_' . $fileId);

        if (!$uploadData) {
            return response()->json(['error' => 'Upload session not found'], 404);
        }

        try {
            $tempPath = $this->mergeChunks($uploadData);
            $finalPath = $this->processImage(file_get_contents($tempPath), 'products');

            // Cleanup
            @unlink($tempPath);
            \Cache::forget('upload_' . $fileId);

            \Log::info("Finalized upload for file: {$uploadData['file_name']}, final path: {$finalPath}");

            return response()->json([
                'success' => true,
                'file_id' => $fileId,
                'path' => $finalPath,
                'message' => 'Upload completed successfully'
            ]);
        } catch (\Exception $e) {
            \Log::error('Finalize upload error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to finalize upload'], 500);
        }
    }

    /**
     * Upload small chunk using FormData
     */
    public function uploadChunkSmall(Request $request)
    {
        \Log::info('Uploading chunk', [
            'file_id' => $request->get('file_id'),
            'chunk_index' => $request->get('chunk_index'),
            'total_chunks' => $request->get('total_chunks')
        ]);

        try {
            $fileId = $request->get('file_id');
            $chunkIndex = (int) $request->get('chunk_index');
            $totalChunks = (int) $request->get('total_chunks');

            $uploadData = \Cache::get('upload_' . $fileId);
            if (!$uploadData) {
                return response()->json(['error' => 'Upload session not found'], 404);
            }

            if (!$request->hasFile('chunk')) {
                return response()->json(['error' => 'No chunk file provided'], 400);
            }

            $chunkFile = $request->file('chunk');
            $chunkContent = file_get_contents($chunkFile->getRealPath());

            // Store chunk temporarily
            $chunkDir = storage_path('app/temp/chunks/' . $fileId);
            if (!file_exists($chunkDir)) {
                mkdir($chunkDir, 0755, true);
            }

            $chunkPath = $chunkDir . '/chunk_' . $chunkIndex;
            file_put_contents($chunkPath, $chunkContent);

            // Update upload data
            $uploadData['chunks'][] = $chunkIndex;
            $uploadData['uploaded_bytes'] += strlen($chunkContent);

            // Update status
            if (count($uploadData['chunks']) === $totalChunks) {
                $uploadData['status'] = 'complete';
            } else {
                $uploadData['status'] = 'uploading';
            }

            \Cache::put('upload_' . $fileId, $uploadData, 3600);

            \Log::info("Chunk {$chunkIndex}/{$totalChunks} uploaded for file {$fileId}");

            return response()->json([
                'success' => true,
                'chunk_index' => $chunkIndex,
                'uploaded_bytes' => $uploadData['uploaded_bytes']
            ]);
        } catch (\Exception $e) {
            \Log::error('Chunk upload error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Upload large file directly (streaming approach)
     */
    public function uploadLargeFile(Request $request)
    {
        \Log::info('Upload large file request', [
            'file_name' => $request->header('X-File-Name'),
            'file_size' => $request->header('X-File-Size'),
            'file_type' => $request->header('X-File-Type')
        ]);

        try {
            $content = file_get_contents('php://input');
            if (empty($content)) {
                return response()->json(['error' => 'No file content received'], 400);
            }

            $fileName = $request->header('X-File-Name');
            $fileSize = $request->header('X-File-Size');
            $fileType = $request->header('X-File-Type');
            $fileId = $request->header('X-File-Id');

            if (!$fileName || !$fileSize) {
                return response()->json(['error' => 'Missing file metadata'], 400);
            }

            // Create a temporary file from the raw content
            $tempPath = tempnam(sys_get_temp_dir(), 'upload_');
            file_put_contents($tempPath, $content);

            // Create a file object from the temp file for processImage
            $tempFile = new \Illuminate\Http\UploadedFile(
                $tempPath,
                $fileName,
                $fileType,
                null,
                true
            );

            // Process the image
            $finalPath = $this->processImage($tempFile, 'products');

            // Cleanup temp file
            @unlink($tempPath);

            \Log::info("Large file uploaded: {$fileName}, size: {$fileSize}, final path: {$finalPath}");

            return response()->json([
                'success' => true,
                'file_id' => $fileId,
                'path' => $finalPath,
                'message' => 'Large file uploaded successfully'
            ]);
        } catch (\Exception $e) {
            \Log::error('Large file upload error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Merge uploaded chunks into final file
     */
    private function mergeChunks(array $uploadData)
    {
        $chunkDir = storage_path('app/temp/chunks/' . $uploadData['chunks'][0] ?? 'temp');
        $finalFile = storage_path('app/temp/' . $uploadData['file_name']);

        if (!file_exists(dirname($finalFile))) {
            mkdir(dirname($finalFile), 0755, true);
        }

        $finalFp = fopen($finalFile, 'wb');

        if (!$finalFp) {
            throw new \Exception('Cannot create final file');
        }

        // Sort chunks by index
        sort($uploadData['chunks']);

        foreach ($uploadData['chunks'] as $chunkIndex) {
            $chunkPath = storage_path('app/temp/chunks/' . $uploadData['file_id'] . '/chunk_' . $chunkIndex);
            if (!file_exists($chunkPath)) {
                fclose($finalFp);
                throw new \Exception("Missing chunk: {$chunkIndex}");
            }

            $chunkContent = file_get_contents($chunkPath);
            fwrite($finalFp, $chunkContent);

            // Cleanup chunk
            @unlink($chunkPath);
        }

        fclose($finalFp);

        // Cleanup chunk directory
        @rmdir(dirname($chunkPath));

        return $finalFile;
    }

    /**
     * Get uploaded files for product edit
     */
    public function getUploadedImages(Request $request)
    {
        $productId = $request->get('product_id');
        $uploadedFiles = \Cache::get('uploaded_files_' . $productId, []);

        return response()->json([
            'files' => $uploadedFiles
        ]);
    }
}
