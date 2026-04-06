<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait HandlesImageUpload
{
    //========== Don't Forget To Run ============
    // php artisan storage:link
    //===========================================

    // {{ asset('storage/' . $post->image) }} # access later in blade using this
    public function uploadImage($file, $folder = 'images')
    {
        if (!$file) {
            return null;
        }

        $path = $file->store($folder, 'public');

        return $path;
    }

    public function updateImage($file, $oldPath = null, $folder = 'images')
    {
        if (!$file) {
            return $oldPath;
        }

        // delete old image
        if ($oldPath && Storage::disk('public')->exists($oldPath)) {
            Storage::disk('public')->delete($oldPath);
        }

        // upload new image
        return $file->store($folder, 'public');
    }
}
