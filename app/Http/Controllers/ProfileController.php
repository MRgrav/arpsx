<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Profile;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use App\Services\StorageServiceInterface;
use App\Services\ImageConverter;

class ProfileController extends Controller
{
    protected StorageServiceInterface $storageService;

    public function __construct(StorageServiceInterface $storageService)
    {
        $this->storageService = $storageService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profiles = Profile::with('role', 'department')->latest()->get();
        return Inertia::render('school-admin/Profiles/Index', compact('profiles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        $departments = Department::all();
        return Inertia::render('school-admin/Profiles/Create', [
            'roles' => $roles,
            'departments' => $departments,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp,avif|max:2048',
            'role_id' => 'nullable|exists:roles,id',
            'position' => 'nullable|string',
            'department_id' => 'nullable|exists:departments,id',
            'detail' => 'nullable|string',
            'message' => 'nullable|string',
            'is_hod' => 'nullable|boolean',
        ]);

        $data['is_hod'] = $request->boolean('is_hod');

        if ($data['is_hod'] && !empty($data['department_id'])) {
            Profile::where('department_id', $data['department_id'])->update(['is_hod' => false]);
        }

        if ($request->hasFile('image')) {
            $convertedImage = ImageConverter::convertToWebPWithSize($request->file('image'), 450);
            $upload = $this->storageService->upload($convertedImage, 'profiles');
            $data['image'] = $upload['url'];
        }

        Profile::create($data);

        return redirect()->route('school-admin.profiles.index')->with('success', 'Profile created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(String $id)
    {
        $profile = Profile::findOrFail($id);
        $profile->load('role');
        $profile->load('department');
        return Inertia::render('school-admin/Profiles/Show', compact('profile'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(String $id)
    {
        $profile = Profile::findOrFail($id);
        $roles = Role::all();
        $departments = Department::all();

        return Inertia::render('school-admin/Profiles/Edit', [
            'profile' => $profile,
            'roles' => $roles,
            'departments' => $departments,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, String $id)
    {
        $profile = Profile::findOrFail($id);

        $rules = [
            'name' => 'required|string|max:255',
            'role_id' => 'required|exists:roles,id',
            'position' => 'nullable|string|max:255',
            'department_id' => 'nullable|exists:departments,id',
            'detail' => 'nullable|string',
            'message' => 'nullable|string',
            'is_hod' => 'nullable|boolean',
        ];

        if ($request->hasFile('image')) {
            $rules['image'] = 'nullable|file|mimes:pdf,jpg,jpeg,png,webp,avif|max:2048';
        }

        $validated = $request->validate($rules);

        $validated['is_hod'] = $request->boolean('is_hod');

        if ($validated['is_hod'] && !empty($validated['department_id'])) {
            Profile::where('department_id', $validated['department_id'])->update(['is_hod' => false]);
        }

        if ($request->hasFile('image')) {
            $oldImage = $profile->image;
            $convertedImage = ImageConverter::convertToWebPWithSize($request->file('image'), 450);
            $upload = $this->storageService->upload($convertedImage, 'profiles');
            $validated['image'] = $upload['url'];
            
            if (!empty($oldImage)) {
                $this->storageService->deleteByUrl($oldImage);
            }
        }

        $profile->update($validated);

        return redirect('/school-admin/profiles')->with('success', 'Profile updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id)
    {
        $profile = Profile::findOrFail($id);
        
        if (!empty($profile->image)) {
            $this->storageService->deleteByUrl($profile->image);
        }
        
        $profile->delete();
        return redirect()->route('school-admin.profiles.index')->with('success', 'Profile deleted.');
    }
}
