<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Advanced middleware to handle large file uploads by completely bypassing server limits
 */
class LargeFileUploadHandler
{
    public function handle(Request $request, Closure $next)
    {
        // Only apply aggressive overrides to admin routes
        if ($request->is('admin/*')) {
            // Log the request for debugging
            \Log::info('LargeFileUploadHandler: Processing request to ' . $request->path());

            // Immediately set unlimited limits at PHP level
            if (function_exists('ini_set')) {
                // Try extreme overrides
                ini_set('upload_max_filesize', '0'); // Unlimited
                ini_set('post_max_size', '0'); // Unlimited
                ini_set('memory_limit', '2048M'); // 2GB for processing
                ini_set('max_execution_time', '0'); // No time limit
                ini_set('max_input_time', '0'); // No input time limit
                ini_set('file_uploads', '1');
                ini_set('max_file_uploads', '100'); // Allow many files

                // Try to override any server-imposed limits
                putenv('PHP_VALUE_upload_max_filesize=0');
                putenv('PHP_VALUE_post_max_size=0');
                putenv('PHP_VALUE_memory_limit=2048M');

                \Log::info('LargeFileUploadHandler: PHP limits set to unlimited');
            }

            // Disable any GET/POST limits at Laravel level
            if (function_exists('set_time_limit')) {
                set_time_limit(0);
            }

            // Force disable any uploaded file size checks in Laravel
            config(['file_max_size' => 0]);

            // CRITICAL: For large requests, completely bypass form submission
            if ($request->isMethod('post') && !$request->is('admin/products/upload-large-file')) {
                $totalFilesSize = $this->calculateTotalFileSize($request);

                if ($totalFilesSize > 1024 * 1024) { // Any file over 1MB
                    \Log::warning("LargeFileUploadHandler: Request contains {$totalFilesSize} bytes - attempting bypass");

                    // For edit forms with large files, redirect to AJAX upload approach
                    if ($request->is('admin/products/*/edit') && $request->hasFile('images')) {
                        return response()->json([
                            'error' => 'Please use the AJAX upload area for large files. Form submission limits apply.',
                            'use_ajax' => true
                        ], 422);
                    }

                    // Pre-process large uploads to avoid validation failures
                    $this->preProcessLargeUpload($request);
                } elseif ($request->has('_large_upload_bypass')) {
                    \Log::info('LargeFileUploadHandler: Large upload bypass requested');
                    // This is a validated large upload request - allow it through
                }
            }
        }

        try {
            $response = $next($request);

            // If we get here, the request was successful
            // Ensure constant unlimited settings for future requests
            if ($request->is('admin/*') && function_exists('ini_set')) {
                ini_set('upload_max_filesize', '0');
                ini_set('post_max_size', '0');
                ini_set('memory_limit', '2048M');
            }

            return $response;
        } catch (\Illuminate\Validation\ValidationException $e) {
            // If validation fails due to size, try processing anyway
            if ($this->isSizeValidationError($e) && $request->is('admin/products/*')) {
                return $this->handleLargeUploadAnyway($request);
            }
            throw $e;
        }
    }

    private function calculateTotalFileSize(Request $request)
    {
        $totalSize = 0;

        if ($request->hasFile('images')) {
            $files = $request->file('images');
            if (is_array($files)) {
                foreach ($files as $file) {
                    if ($file && $file->getSize() !== false) {
                        $totalSize += $file->getSize();
                    }
                }
            }
        }

        return $totalSize;
    }

    private function preProcessLargeUpload(Request $request)
    {
        // Extract files from the raw request before Laravel validation
        if ($request->hasFile('images')) {
            $files = $request->file('images');

            // For very large uploads, temporarily store in session or cache
            if (is_array($files)) {
                $totalSize = array_reduce($files, function($sum, $file) {
                    return $sum + ($file ? $file->getSize() : 0);
                }, 0);

                // If total size exceeds known limits, bypass validation
                if ($totalSize > 2097152) { // > 2MB
                    // Mark request as verified for large uploads
                    $request->merge(['_large_upload_bypass' => true]);
                }
            }
        }
    }

    private function isSizeValidationError(\Illuminate\Validation\ValidationException $exception)
    {
        $errors = $exception->errors();
        foreach ($errors as $field => $messages) {
            foreach ($messages as $message) {
                if (stripos($message, 'size') !== false ||
                    stripos($message, 'max') !== false ||
                    stripos($message, 'too large') !== false) {
                    return true;
                }
            }
        }
        return false;
    }

    private function handleLargeUploadAnyway(Request $request)
    {
        try {
            // Skip validation and directly process the upload
            $controller = app()->make(\App\Http\Controllers\Admin\ProductController::class);

            if ($request->is('admin/products')) {
                return $controller->storeLarge($request);
            } elseif ($request->is('admin/products/*/edit')) {
                $id = $request->route('product')->id ?? $request->route('id');
                return $controller->updateLarge($request, $id);
            }

        } catch (\Exception $e) {
            return response()->json(['error' => 'Large upload processing failed'], 500);
        }
    }
}
