<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;

interface StorageServiceInterface
{
    /**
     * Upload a file to the storage provider.
     * Returns an array: ['file_id' => string, 'url' => string]
     */
    public function upload(UploadedFile $file, string $target = null): array;

    /**
     * Delete a file by target (bucket/collection) and file/record ID.
     */
    public function delete(string $target, string $id): bool;

    /**
     * Delete a file by its direct URL.
     */
    public function deleteByUrl(string $url, string $target = null): bool;
}
