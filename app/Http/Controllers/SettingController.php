<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Services\StorageServiceInterface;
use App\Services\ImageConverter;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SettingController extends Controller
{
    private StorageServiceInterface $storageService;

    public function __construct(StorageServiceInterface $storageService)
    {
        $this->storageService = $storageService;
    }

    /**
     * Display the settings page.
     */
    public function index()
    {
        return Inertia::render('school-admin/Settings', [
            'settings' => [
                'registration_enabled' => Setting::get('registration_enabled', '1') === '1',
                'hs_registration_enabled' => Setting::get('hs_registration_enabled', '1') === '1',
                'registration_message' => Setting::get('registration_message', ''),
                'hs_registration_message' => Setting::get('hs_registration_message', ''),
                'registration_classes' => json_decode(Setting::get('registration_classes', '[]'), true) ?: [],
                'registration_categories' => json_decode(Setting::get('registration_categories', '[]'), true) ?: [],
                'registration_defence_categories' => json_decode(Setting::get('registration_defence_categories', '[]'), true) ?: [],
                'flash_update_enabled' => Setting::get('flash_update_enabled', '1') === '1',
                'flash_update_image' => Setting::get('flash_update_image', ''),
                'flash_update_image_mobile' => Setting::get('flash_update_image_mobile', ''),
            ]
        ]);
    }

    /**
     * Update settings.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'registration_enabled' => 'nullable|boolean',
            'hs_registration_enabled' => 'nullable|boolean',
            'registration_message' => 'nullable|string',
            'hs_registration_message' => 'nullable|string',
            'registration_classes' => 'nullable|array',
            'registration_classes.*' => 'string',
            'registration_categories' => 'nullable|array',
            'registration_categories.*' => 'string',
            'registration_defence_categories' => 'nullable|array',
            'registration_defence_categories.*' => 'string',
            'flash_update_enabled' => 'nullable|boolean',
            'flash_update_image_file' => 'nullable|image|max:4096',
        ]);

        if (isset($validated['registration_enabled'])) {
            Setting::set('registration_enabled', $validated['registration_enabled'] ? '1' : '0');
        }

        if (isset($validated['hs_registration_enabled'])) {
            Setting::set('hs_registration_enabled', $validated['hs_registration_enabled'] ? '1' : '0');
        }
        
        if (isset($validated['registration_message'])) {
            Setting::set('registration_message', $validated['registration_message']);
        }
        
        if (isset($validated['hs_registration_message'])) {
            Setting::set('hs_registration_message', $validated['hs_registration_message']);
        }
        
        if (isset($validated['registration_classes'])) {
            Setting::set('registration_classes', json_encode($validated['registration_classes']));
        }
        
        if (isset($validated['registration_categories'])) {
            Setting::set('registration_categories', json_encode($validated['registration_categories']));
        }
        
        if (isset($validated['registration_defence_categories'])) {
            Setting::set('registration_defence_categories', json_encode($validated['registration_defence_categories']));
        }

        if (isset($validated['flash_update_enabled'])) {
            Setting::set('flash_update_enabled', $validated['flash_update_enabled'] ? '1' : '0');
        }

        if ($request->hasFile('flash_update_image_file')) {
            try {
                $file = $request->file('flash_update_image_file');

                // Retrieve old images to delete them from storage
                $oldDesktopUrl = Setting::get('flash_update_image', '');
                $oldMobileUrl = Setting::get('flash_update_image_mobile', '');

                // Convert to optimized WebP format
                $optimizedFile = ImageConverter::convertToWebP($file);
                $upload = $this->storageService->upload($optimizedFile);

                if (isset($upload['url'])) {
                    // Store new URL
                    Setting::set('flash_update_image', $upload['url']);
                    
                    // Clear the mobile setting since we now use a single responsive file
                    Setting::set('flash_update_image_mobile', '');

                    // Delete old files from storage
                    if (!empty($oldDesktopUrl)) {
                        try {
                            $this->storageService->deleteByUrl($oldDesktopUrl);
                        } catch (\Exception $e) {
                            \Log::warning("Stale desktop image deletion failed: " . $e->getMessage());
                        }
                    }
                    if (!empty($oldMobileUrl)) {
                        try {
                            $this->storageService->deleteByUrl($oldMobileUrl);
                        } catch (\Exception $e) {
                            \Log::warning("Stale mobile image deletion failed: " . $e->getMessage());
                        }
                    }
                } else {
                    return redirect()->back()->with('error', 'Storage upload succeeded but returned no view URL.');
                }
            } catch (\Exception $e) {
                \Log::error("Banner upload failed: " . $e->getMessage());
                return redirect()->back()->with('error', 'Banner upload failed: ' . $e->getMessage());
            }
        }

        return redirect()->back()->with('success', 'Settings updated successfully.');
    }

    /**
     * Toggle a specific setting flag via AJAX / Inertia request.
     */
    public function toggle(Request $request)
    {
        $validated = $request->validate([
            'key' => 'required|string|in:registration_enabled,hs_registration_enabled,flash_update_enabled',
            'value' => 'required|boolean',
        ]);

        Setting::set($validated['key'], $validated['value'] ? '1' : '0');

        return redirect()->back()->with('success', 'Status updated successfully.');
    }
}
