<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;

class ParallelStorageService implements StorageServiceInterface
{
    protected AppwriteStorageService $appwrite;
    protected PocketBaseStorageService $pocketbase;

    public function __construct(
        AppwriteStorageService $appwrite,
        PocketBaseStorageService $pocketbase
    ) {
        $this->appwrite = $appwrite;
        $this->pocketbase = $pocketbase;
    }

    public function upload(UploadedFile $file, string $collectionName = null): array
    {
        $pocketbaseResult = null;
        $appwriteResult = null;
        $url = null;

        try {
            $pocketbaseResult = $this->pocketbase->upload($file, $collectionName);
            $url = $pocketbaseResult['url'];
        } catch (\Exception $e) {
            \Log::error("PocketBase upload failed: " . $e->getMessage());
        }

        try {
            $appwriteResult = $this->appwrite->upload($file, $collectionName);
            if (!$url) {
                $url = $appwriteResult['url'];
            }
        } catch (\Exception $e) {
            // Log or ignore
        }

        if (!$url) {
            throw new \Exception("Both PocketBase and Appwrite uploads failed.");
        }

        return [
            'url' => $url,
            'appwrite_url' => $appwriteResult['url'] ?? null,
            'pocketbase_url' => $pocketbaseResult['url'] ?? null,
        ];
    }

    public function delete(string $target, string $id): bool
    {
        try {
            $this->appwrite->delete($target, $id);
        } catch (\Exception $e) {}

        try {
            $this->pocketbase->delete($target, $id);
        } catch (\Exception $e) {}

        return true;
    }

    public function deleteByUrl(string $url, string $target = null): bool
    {
        try {
            $this->appwrite->deleteByUrl($url, $target);
        } catch (\Exception $e) {}

        try {
            $this->pocketbase->deleteByUrl($url, $target);
        } catch (\Exception $e) {}

        return true;
    }
}
