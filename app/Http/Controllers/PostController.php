<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class PostController extends Controller
{
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
            'image' => "required|file|mimes:pdf,jpg,jpeg,png|max:2048",
            'images' => 'nullable|array',
            'images.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'content' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            // Generate UUID and keep original extension
            $extension = $request->file('image')->getClientOriginalExtension();
            $filename = Str::uuid()->toString() . '.' . $extension;

            // Store in public/uploads
            $request->file('image')->storeAs('uploads', $filename, 'public');

            $data['image'] = $filename;
        }

        $storedImages = [];

        foreach ($request->file('images', []) as $file) {
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('uploads', $filename, 'public');
            $storedImages[] = $filename;
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
            'title'   => 'required|string',
            'image'   => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'images'  => 'nullable|array',
            'images.*' => 'nullable',
            'content' => 'nullable|string',
        ]);

        /**
         * Update main thumbnail image
         */
        if ($request->hasFile('image')) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $filename = Str::uuid() . '.' . $extension;
            $request->file('image')->storeAs('uploads', $filename, 'public');
            $validated['image'] = $filename;
        } else {
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

        // New uploaded images (Files)
        $newUploads = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                if ($file) {
                    $fname = Str::uuid() . '.' . $file->getClientOriginalExtension();
                    $file->storeAs('uploads', $fname, 'public');
                    $newUploads[] = $fname;
                }
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
        $post->delete();
        return redirect()->route('school-admin.posts.index')->with('success', 'Post deleted.');
    }
}
