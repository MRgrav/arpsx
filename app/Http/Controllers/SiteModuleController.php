<?php

namespace App\Http\Controllers;

use App\Models\SiteModule;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Services\StorageServiceInterface;

class SiteModuleController extends Controller
{
    protected StorageServiceInterface $storageService;

    public function __construct(StorageServiceInterface $storageService)
    {
        $this->storageService = $storageService;
    }

    /**
     * Display a listing of the site modules.
     */
    public function index()
    {
        $modules = SiteModule::latest()->get();
        return Inertia::render('school-admin/SiteModules/Index', [
            'modules' => $modules,
        ]);
    }

    /**
     * Store a newly created site module in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:site_modules,name',
            'files' => 'nullable|array',
            'files.*' => 'nullable|file|max:10240', // 10MB max per file
        ]);

        $uploadedFiles = [];

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                // Determine file type
                $extension = strtolower($file->getClientOriginalExtension());
                $mime = $file->getMimeType();
                $type = 'other';
                
                if (in_array($extension, ['jpg', 'jpeg', 'png', 'webp', 'avif']) || str_starts_with($mime, 'image/')) {
                    $type = 'image';
                } elseif (in_array($extension, ['mp4', 'webm', 'ogg']) || str_starts_with($mime, 'video/')) {
                    $type = 'video';
                } elseif ($extension === 'pdf' || $mime === 'application/pdf') {
                    $type = 'pdf';
                }

                $upload = $this->storageService->upload($file, 'site_modules');
                
                $uploadedFiles[] = [
                    'url' => $upload['url'],
                    'name' => $file->getClientOriginalName(),
                    'type' => $type,
                ];
            }
        }

        SiteModule::create([
            'name' => $validated['name'],
            'files' => $uploadedFiles,
        ]);

        return redirect()->route('school-admin.site-modules.index')->with('success', 'Site Module created successfully.');
    }

    /**
     * Update the specified site module in storage.
     */
    public function update(Request $request, SiteModule $siteModule)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:site_modules,name,' . $siteModule->id,
            'existing_files' => 'nullable|array',
            'new_files' => 'nullable|array',
            'new_files.*' => 'nullable|file|max:10240',
        ]);

        $existingFiles = $siteModule->files ?? [];
        $keptFiles = $request->input('existing_files', []);

        // Delete removed files from storage
        foreach ($existingFiles as $oldFile) {
            $isKept = collect($keptFiles)->contains('url', $oldFile['url']);
            if (!$isKept) {
                $this->storageService->deleteByUrl($oldFile['url']);
            }
        }

        $uploadedFiles = [];

        if ($request->hasFile('new_files')) {
            foreach ($request->file('new_files') as $file) {
                // Determine file type
                $extension = strtolower($file->getClientOriginalExtension());
                $mime = $file->getMimeType();
                $type = 'other';
                
                if (in_array($extension, ['jpg', 'jpeg', 'png', 'webp', 'avif']) || str_starts_with($mime, 'image/')) {
                    $type = 'image';
                } elseif (in_array($extension, ['mp4', 'webm', 'ogg']) || str_starts_with($mime, 'video/')) {
                    $type = 'video';
                } elseif ($extension === 'pdf' || $mime === 'application/pdf') {
                    $type = 'pdf';
                }

                $upload = $this->storageService->upload($file, 'site_modules');
                
                $uploadedFiles[] = [
                    'url' => $upload['url'],
                    'name' => $file->getClientOriginalName(),
                    'type' => $type,
                ];
            }
        }

        $siteModule->update([
            'name' => $validated['name'],
            'files' => array_merge($keptFiles, $uploadedFiles),
        ]);

        return redirect()->route('school-admin.site-modules.index')->with('success', 'Site Module updated successfully.');
    }

    /**
     * Remove the specified site module from storage.
     */
    public function destroy(SiteModule $siteModule)
    {
        if (is_array($siteModule->files)) {
            foreach ($siteModule->files as $file) {
                $this->storageService->deleteByUrl($file['url']);
            }
        }

        $siteModule->delete();
        return redirect()->route('school-admin.site-modules.index')->with('success', 'Site Module deleted successfully.');
    }
}
