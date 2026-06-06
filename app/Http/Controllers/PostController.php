<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use App\Services\StorageServiceInterface;

class PostController extends Controller
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
        $posts = Post::latest()->get();
        return Inertia::render('school-admin/Posts/Index', [
            'posts' => $posts
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('school-admin/Posts/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'image' => "required|file|mimes:pdf,jpg,jpeg,png,webp,avif|max:2048",
            'images' => 'nullable|array',
            'images.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,webp,avif|max:2048',
            'content' => 'nullable|string',
        ]);

        // if ($request->hasFile('image')) {
        //     // Generate UUID and keep original extension
        //     $extension = $request->file('image')->getClientOriginalExtension();
        //     $filename = Str::uuid()->toString() . '.' . $extension;

        //     // Store in public/uploads
        //     $request->file('image')->storeAs('uploads', $filename, 'public');

        //     $data['image'] = $filename;
        // }

        // $storedImages = [];

        // foreach ($request->file('images', []) as $file) {
        //     $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        //     $file->storeAs('uploads', $filename, 'public');
        //     $storedImages[] = $filename;
        // }

        // $data['images'] = $storedImages;

        // 1. Handle Main Thumbnail Upload
        if ($request->hasFile('image')) {
            // Convert main thumbnail image to optimized WebP format
            $convertedImage = \App\Services\ImageConverter::convertToWebP($request->file('image'));
            $upload = $this->storageService->upload($convertedImage);
            $data['image'] = $upload['url']; // Store the URL in DB
        }

        // 2. Handle Gallery Images Upload
        $storedImages = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                // Convert gallery image to optimized WebP format
                $convertedFile = \App\Services\ImageConverter::convertToWebP($file);
                $upload = $this->storageService->upload($convertedFile);
                $storedImages[] = $upload['url'];
            }
        }
        $data['images'] = $storedImages;

        Post::create($data);

        return redirect()->route('school-admin.posts.index')->with('success', 'Post created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::findOrFail($id);
        return Inertia::render('school-admin/Posts/Show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = Post::findOrFail($id);
        return Inertia::render('school-admin/Posts/Edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $post = Post::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string',
            'image' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'images' => 'nullable|array',
            'images.*' => 'nullable',
            'content' => 'nullable|string',
        ]);

        /**
         * Update main thumbnail image
         */
        // if ($request->hasFile('image')) {
        //     $extension = $request->file('image')->getClientOriginalExtension();
        //     $filename = Str::uuid() . '.' . $extension;
        //     $request->file('image')->storeAs('uploads', $filename, 'public');
        //     $validated['image'] = $filename;
        // } else {
        //     unset($validated['image']);
        // }

        if ($request->hasFile('image')) {
            $oldImage = $post->image;
            // Convert main thumbnail image to optimized WebP format
            $convertedImage = \App\Services\ImageConverter::convertToWebP($request->file('image'));
            $upload = $this->storageService->upload($convertedImage);
            $validated['image'] = $upload['url'];
            if (!empty($oldImage)) {
                $this->storageService->deleteByUrl($oldImage);
            }
        } else {
            // Keep existing URL if no new file is uploaded
            unset($validated['image']);
        }


        /**
         * GALLERY UPDATE (Order does NOT matter)
         */

        // Existing gallery from DB
        $existingImages = $post->images ?? [];

        // Images user kept (strings)
        $keptImages = array_filter($request->input('images', []), function ($value) {
            return is_string($value) && !empty($value);
        });

        // Delete removed gallery images
        $deletedImages = array_diff($existingImages, $keptImages);
        foreach ($deletedImages as $deletedImage) {
            if (!empty($deletedImage)) {
                $this->storageService->deleteByUrl($deletedImage);
            }
        }

        $newUploads = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                // Convert gallery image to optimized WebP format
                $convertedFile = \App\Services\ImageConverter::convertToWebP($file);
                $upload = $this->storageService->upload($convertedFile);
                $newUploads[] = $upload['url'];
            }
        }

        // Final gallery = kept + newly uploaded
        $validated['images'] = array_values(array_merge($keptImages, $newUploads));


        /**
         * Final update
         */
        $post->update($validated);

        return redirect()
            ->route('school-admin.posts.index')
            ->with('success', 'Post updated successfully.');
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);

        // Delete main thumbnail
        if (!empty($post->image)) {
            $this->storageService->deleteByUrl($post->image);
        }

        // Delete gallery images
        if (is_array($post->images)) {
            foreach ($post->images as $img) {
                if (!empty($img)) {
                    $this->storageService->deleteByUrl($img);
                }
            }
        }

        $post->delete();
        return redirect()->route('school-admin.posts.index')->with('success', 'Post deleted.');
    }
}
