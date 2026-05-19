<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class ImageConverter
{
    /**
     * Convert an uploaded image to WebP format if it is jpg, jpeg, or png.
     * Returns a new UploadedFile pointing to the temporary webp file.
     * If the file is not a supported image, returns the original file.
     */
    public static function convertToWebP(UploadedFile $file): UploadedFile
    {
        $extension = strtolower($file->getClientOriginalExtension());
        $mime = $file->getMimeType();

        // Check if the file is a converter-supported image extension/mime
        if (!in_array($extension, ['jpg', 'jpeg', 'png']) && !Str::startsWith($mime, 'image/')) {
            return $file;
        }

        // Avoid converting already optimized formats (webp, gif, svg)
        if (in_array($extension, ['webp', 'gif', 'svg'])) {
            return $file;
        }

        try {
            $imagePath = $file->getRealPath();
            $image = null;

            if ($extension === 'png' || $mime === 'image/png') {
                $image = @imagecreatefrompng($imagePath);
            } elseif (in_array($extension, ['jpg', 'jpeg']) || in_array($mime, ['image/jpeg', 'image/jpg'])) {
                $image = @imagecreatefromjpeg($imagePath);
            }

            if (!$image) {
                return $file;
            }

            // Preserve alpha channel and transparency for PNG/JPEG conversions
            imagepalettetotruecolor($image);
            imagealphablending($image, true);
            imagesavealpha($image, true);

            // Generate a unique temporary path for the converted file
            $tempFile = tempnam(sys_get_temp_dir(), 'webp_');
            unlink($tempFile); // unlink to write with proper extension
            $tempFileWebp = $tempFile . '.webp';

            // Convert and write the WebP file with 80% compression quality
            if (@imagewebp($image, $tempFileWebp, 80)) {
                imagedestroy($image);

                // Register a shutdown function to automatically purge the temp file at request end
                register_shutdown_function(function () use ($tempFileWebp) {
                    if (file_exists($tempFileWebp)) {
                        @unlink($tempFileWebp);
                    }
                });

                // Generate new file name with the webp extension
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $newName = $originalName . '.webp';

                // Return the new UploadedFile in test mode (5th param = true) so validation passes
                return new UploadedFile(
                    $tempFileWebp,
                    $newName,
                    'image/webp',
                    null,
                    true
                );
            }

            imagedestroy($image);
        } catch (\Throwable $e) {
            // If any error occurs (e.g. out of memory, invalid file), fallback to the original file
        }

        return $file;
    }
}
