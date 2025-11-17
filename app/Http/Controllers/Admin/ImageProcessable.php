<?php

namespace App\Http\Controllers\Admin;

trait ImageProcessable
{
    private function processImage($file, $folder)
    {
        try {
            $manager = \Intervention\Image\ImageManager::gd();
            $imageName = time() . '_' . uniqid() . '.webp';
            $path = storage_path('app/public/' . $folder . '/' . $imageName);

            // Create directory if it doesn't exist
            $directory = dirname($path);
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }

            // Process and save the image
            $image = $manager->read($file);

            // Resize to max 1920px width while maintaining aspect ratio
            if ($image->width() > 1920) {
                $image->scale(width: 1920);
            }

            // Convert and save as WebP with 85% quality
            $image->toWebp(85)->save($path);

            return $folder . '/' . $imageName;
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Image processing failed for ' . $folder . ': ' . $e->getMessage());

            // Fallback: save original file if processing fails
            $originalName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $originalPath = storage_path('app/public/' . $folder . '/' . $originalName);

            // Create directory if needed
            $originalDir = dirname($originalPath);
            if (!file_exists($originalDir)) {
                mkdir($originalDir, 0755, true);
            }

            $file->move($originalDir, $originalName);
            return $folder . '/' . $originalName;
        }
    }
}
