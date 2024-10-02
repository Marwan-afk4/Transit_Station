<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class ImageuploadService
{
    public function uploadBase64Image($base64Image, $folder = 'profile_images')
    {
        if (preg_match('/^data:image\/(\w+);base64,/', $base64Image, $type)) {
            $base64Image = substr($base64Image, strpos($base64Image, ',') + 1);
            $base64Image = base64_decode($base64Image);

            if ($base64Image === false) {
                throw new \Exception('Base64 decode failed');
            }

            $fileName = $folder . '/' . uniqid() . '.png';
            Storage::disk('public')->put($fileName, $base64Image);

            return $fileName;
        }

        return null;
    }
}
