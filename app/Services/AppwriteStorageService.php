<?php

namespace App\Services;

use Appwrite\Client;
use Appwrite\Services\Storage;
use Appwrite\InputFile;
use Appwrite\ID;
use Illuminate\Http\UploadedFile;

class AppwriteStorageService
{
    protected $storage;
    protected $projectId;
    protected $endpoint;
    protected $awBucketId;

    public function __construct()
    {
        $this->projectId = config('services.appwrite.project_id');
        $this->endpoint = config('services.appwrite.endpoint'); // e.g., https://your-ip/v1
        // $this->awBucketId = env('APPWRITE_BUCKET_ID');  // config('services.appwrite.bucket_id');

        $client = new Client();
        $client
            ->setEndpoint($this->endpoint)
            ->setProject($this->projectId)
            ->setKey(config('services.appwrite.api_key'));

        $this->storage = new Storage($client);
    }

    /**
     * Upload a file and return the permanent view URL.
     */
    public function upload(UploadedFile $file, string $bucketId = 'default'): array
    {
        $result = $this->storage->createFile(
            $bucketId,
            ID::unique(),
            InputFile::fromPath($file->getRealPath(), $file->getClientOriginalName())
        );

        return [
            'file_id' => $result['$id'],
            'url' => $this->getRawUrl($bucketId, $result['$id'])
        ];
    }

    /**
     * Generate the direct View URL (No SDK call needed to display).
     */
    public function getRawUrl(string $bucketId, string $fileId): string
    {
        return "{$this->endpoint}/storage/buckets/{$bucketId}/files/{$fileId}/view?project={$this->projectId}";
    }

    /**
     * Delete a file from Appwrite.
     */
    public function delete(string $bucketId, string $fileId): bool
    {
        try {
            $this->storage->deleteFile($bucketId, $fileId);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}