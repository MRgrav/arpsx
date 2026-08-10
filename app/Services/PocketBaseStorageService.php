<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;

class PocketBaseStorageService implements StorageServiceInterface
{
    protected string $url;
    protected string $defaultCollection;

    public function __construct()
    {
        $this->url = rtrim(config('services.pocketbase.url', 'http://127.0.0.1:8090'), '/');
        $this->defaultCollection = config('services.pocketbase.collection', 'files');
    }

    /**
     * Upload a file to PocketBase and return file info with URL.
     */
    public function upload(UploadedFile $file, string $target = null): array
    {
        $collection = $this->defaultCollection;
        $endpoint = "{$this->url}/api/collections/{$collection}/records";

        // PocketBase expects a multipart POST request with the file field
        $response = Http::attach(
            'field',
            file_get_contents($file->getRealPath()),
            $file->getClientOriginalName(),
            ['Content-Type' => $file->getClientMimeType()]
        )->post($endpoint, [
            'media_for' => $target ?: 'unknown'
        ]);

        if ($response->failed()) {
            throw new \Exception("PocketBase upload failed: " . $response->body());
        }

        $data = $response->json();
        $recordId = $data['id'];
        
        // PocketBase returns the actual stored filename inside the file field
        $fileName = $data['field'] ?? '';

        // pocketbase file URL format: http://127.0.0.1:8090/api/files/{collectionId_or_name}/{recordId}/{fileName}
        $fileUrl = "{$this->url}/api/files/{$collection}/{$recordId}/{$fileName}";

        return [
            'file_id' => $recordId,
            'url' => $fileUrl
        ];
    }

    /**
     * Delete a record (and its associated file) from PocketBase.
     */
    public function delete(string $collection, string $recordId): bool
    {
        $endpoint = "{$this->url}/api/collections/{$collection}/records/{$recordId}";
        $response = Http::delete($endpoint);

        return $response->successful();
    }

    /**
     * Delete an image from PocketBase storage by its URL.
     */
    public function deleteByUrl(string $url, string $collectionName = null): bool
    {
        if (empty($url)) {
            return false;
        }

        $path = parse_url($url, PHP_URL_PATH);
        if ($path) {
            $parts = explode('/', trim($path, '/'));
            // parts pattern: ['api', 'files', {collectionId}, {recordId}, {fileName}]
            if (count($parts) >= 4 && $parts[0] === 'api' && $parts[1] === 'files') {
                $urlCollection = $parts[2];
                $recordId = $parts[3];
                return $this->delete($urlCollection, $recordId);
            }
        }

        return false;
    }
}
