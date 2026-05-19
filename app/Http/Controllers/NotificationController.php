<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Services\AppwriteStorageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class NotificationController extends Controller
{
    protected $storageService;
    // Inject the service via Constructor for cleaner access
    public function __construct(AppwriteStorageService $storageService)
    {
        $this->storageService = $storageService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('school-admin/Notifications/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'nullable|string',
            'files.*' => "nullable|file|mimes:pdf,jpg,jpeg,png|max:2048"
        ]);

        $links = [];
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                // Convert image files to optimized WebP format
                $convertedFile = \App\Services\ImageConverter::convertToWebP($file);
                $upload = $this->storageService->upload($convertedFile, config('services.appwrite.bucket_id'));
                $fileType = $convertedFile->getMimeType() === 'application/pdf' ? 'pdf' : 'image';
                $links[] = ['url' => $upload['url'], 'type' => $fileType];
            }
        }

        Notification::create([
            'title' => $validated['title'],
            'message' => $validated['message'] ?? null,
            'user_id' => Auth::id(),
            'links' => $links,
        ]);

        return redirect()->route('school-admin.notifications.schoolAdminIndex')
            ->with('success', 'Notification created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $notification = Notification::findOrFail($id);
        return Inertia::render('school-admin/Notifications/Show', [
            'notification' => $notification,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $notification = Notification::findOrFail($id);
        return Inertia::render('school-admin/Notifications/Edit', [
            'notification' => $notification,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $notification = Notification::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'nullable|string',
            'links' => 'nullable|array', // Existing links the user wants to keep
            'files.*' => "nullable|file|mimes:pdf,jpg,jpeg,png|max:2048"
        ]);

        // 1. New uploads
        $newUploads = [];
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                // Convert image files to optimized WebP format
                $convertedFile = \App\Services\ImageConverter::convertToWebP($file);
                $upload = $this->storageService->upload($convertedFile, config('services.appwrite.bucket_id'));
                $fileType = $convertedFile->getMimeType() === 'application/pdf' ? 'pdf' : 'image';
                $newUploads[] = ['url' => $upload['url'], 'type' => $fileType];
            }
        }

        // 2. Kept links (filter to ensure they are valid {url, type} objects)
        $keptLinks = array_filter($request->input('links', []), function ($value) {
            return is_array($value) && !empty($value['url']) && !empty($value['type']);
        });

        // 3. Merge and update
        $notification->update([
            'title' => $validated['title'],
            'message' => $validated['message'],
            'links' => array_values(array_merge($keptLinks, $newUploads)),
        ]);

        return redirect()
            ->route('school-admin.notifications.schoolAdminIndex')
            ->with('success', 'Notification updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $notification = Notification::findOrFail($id);

        $notification->delete();

        return redirect()
            ->route('school-admin.notifications.schoolAdminIndex')
            ->with('success', 'Notification deleted successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function schoolAdminIndex()
    {

        $notifications = Notification::latest('created_at')->get();

        return Inertia::render('school-admin/Notifications/Index', [
            'notifications' => $notifications,
        ]);
    }
}
