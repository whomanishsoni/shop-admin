<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Upload Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for handling large file uploads with unlimited sizes
    | This overrides default PHP upload limits for better user experience
    |
    */

    'max_file_size' => 0, // 0 = unlimited

    'max_post_size' => 0, // 0 = unlimited

    'memory_limit' => '1024M',

    'max_execution_time' => 300, // 5 minutes

    'max_input_time' => 300, // 5 minutes

    'file_types_allowed' => [
        'images' => ['jpg', 'jpeg', 'png', 'gif', 'webp'],
        'videos' => ['mp4', 'avi', 'mov', 'wmv', 'flv', 'mkv'],
        'documents' => ['pdf', 'doc', 'docx', 'txt', 'xlsx', 'xls'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Image Processing Settings
    |--------------------------------------------------------------------------
    |
    | Settings for automatic image compression and conversion
    |
    */

    'image_processing' => [
        'webp_quality' => 85, // 85% quality for WebP conversion

        'max_width' => 1920, // Resize images larger than this width

        'maintain_aspect_ratio' => true,

        'fallback_format' => 'original', // Keep original format if WebP conversion fails
    ],
];
