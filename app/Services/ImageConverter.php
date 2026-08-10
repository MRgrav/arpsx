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
        if (in_array($extension, ['webp', 'gif', 'svg', 'avif'])) {
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

    /**
     * Convert and resize an uploaded image to WebP with target width.
     */
    public static function convertToWebPWithSize(UploadedFile $file, int $targetWidth): UploadedFile
    {
        $extension = strtolower($file->getClientOriginalExtension());
        $mime = $file->getMimeType();

        // Check if the file is a converter-supported image extension/mime
        if (!in_array($extension, ['jpg', 'jpeg', 'png', 'webp']) && !Str::startsWith($mime, 'image/')) {
            return $file;
        }

        try {
            $imagePath = $file->getRealPath();
            $srcImage = null;

            if ($extension === 'png' || $mime === 'image/png') {
                $srcImage = @imagecreatefrompng($imagePath);
            } elseif ($extension === 'webp' || $mime === 'image/webp') {
                $srcImage = @imagecreatefromwebp($imagePath);
            } else {
                $srcImage = @imagecreatefromjpeg($imagePath);
            }

            if (!$srcImage) {
                return $file;
            }

            $origWidth = imagesx($srcImage);
            $origHeight = imagesy($srcImage);

            // Calculate height maintaining aspect ratio
            if ($origWidth > $targetWidth) {
                $targetHeight = (int) (($origHeight / $origWidth) * $targetWidth);
            } else {
                // If the original image is narrower than target width, do not upscale
                $targetWidth = $origWidth;
                $targetHeight = $origHeight;
            }

            // Create target true-color image
            $dstImage = imagecreatetruecolor($targetWidth, $targetHeight);
            imagepalettetotruecolor($dstImage);
            imagealphablending($dstImage, false);
            imagesavealpha($dstImage, true);

            // Preserve transparency if the source image had it
            if ($extension === 'png' || $mime === 'image/png' || $extension === 'webp' || $mime === 'image/webp') {
                imagealphablending($srcImage, true);
            }

            // Perform resize
            imagecopyresampled($dstImage, $srcImage, 0, 0, 0, 0, $targetWidth, $targetHeight, $origWidth, $origHeight);

            // Generate a unique temporary path for the converted file
            $tempFile = tempnam(sys_get_temp_dir(), 'webp_w' . $targetWidth . '_');
            unlink($tempFile); // unlink to write with proper extension
            $tempFileWebp = $tempFile . '.webp';

            // Convert and write the WebP file with 80% compression quality
            if (@imagewebp($dstImage, $tempFileWebp, 80)) {
                imagedestroy($srcImage);
                imagedestroy($dstImage);

                // Register a shutdown function to automatically purge the temp file at request end
                register_shutdown_function(function () use ($tempFileWebp) {
                    if (file_exists($tempFileWebp)) {
                        @unlink($tempFileWebp);
                    }
                });

                // Generate new file name
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $newName = $originalName . '-' . $targetWidth . '.webp';

                return new UploadedFile(
                    $tempFileWebp,
                    $newName,
                    'image/webp',
                    null,
                    true
                );
            }

            imagedestroy($srcImage);
            imagedestroy($dstImage);
        } catch (\Throwable $e) {
            // Fallback
        }

        return $file;
    }
}
