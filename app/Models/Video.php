<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = [
        'title', 'video_path', 'status', 'sort_order'
    ];

    public function getFileSize()
    {
        try {
            $path = storage_path('app/public/' . $this->video_path);
            if (file_exists($path)) {
                $bytes = filesize($path);
                $units = ['B', 'KB', 'MB', 'GB'];
                $i = 0;
                while ($bytes >= 1024 && $i < count($units) - 1) {
                    $bytes /= 1024;
                    $i++;
                }
                return round($bytes, 1) . ' ' . $units[$i];
            }
        } catch (\Exception $e) {
            // Handle error silently
        }
        return null;
    }

    public function getDuration()
    {
        try {
            $path = storage_path('app/public/' . $this->video_path);
            if (file_exists($path)) {
                // Use FFmpeg to get duration (requires FFmpeg installed)
                $command = "ffprobe -v quiet -print_format json -show_format " . escapeshellarg($path);
                $output = shell_exec($command);

                if ($output) {
                    $data = json_decode($output, true);
                    if (isset($data['format']['duration'])) {
                        $duration = (float) $data['format']['duration'];
                        $minutes = floor($duration / 60);
                        $seconds = round($duration % 60);
                        return sprintf('%d:%02d', $minutes, $seconds);
                    }
                }
            }
        } catch (\Exception $e) {
            // Handle error silently
        }
        return null;
    }
}
