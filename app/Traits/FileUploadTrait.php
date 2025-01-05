<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

trait FileUploadTrait
{
    function handleImageUpload(Request $request, string $fieldName, ?string $oldPath = null, string $dir = 'uploads'): ?String
    {
        if (!$request->hasFile($fieldName)) {
            return null;
        }

        if ($oldPath != (config('common.no_image'))) {
            if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
        }

        $file = $request->file($fieldName);
        $extension = $file->getClientOriginalExtension();
        $updatedFileName = $dir . '_' . date('Ymdhis') . '.' . $extension;

        Storage::disk('public')->putFileAs("/images/$dir", $file, $updatedFileName);

        $filePath = "/images/$dir/$updatedFileName";

        return $filePath;
    }
}
