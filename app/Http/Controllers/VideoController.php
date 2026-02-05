<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    /**
     * Admin dashboard view with search and filters
     */
    public function index(Request $request)
    {
        $query = Video::query();

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('status')) {
            $status = $request->status === 'active' ? 1 : 0;
            $query->where('is_active', $status);
        }

        $videos = $query->latest()->get();
        $categories = Video::whereNotNull('category')->distinct()->pluck('category');

        return view('admin.dashboard', compact('videos', 'categories'));
    }

    /**
     * Public overview page (client-facing)
     */
    public function overview(Request $request)
    {
        $query = Video::where('is_active', true);

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $videos = $query->latest()->get();
        $categories = Video::where('is_active', true)->whereNotNull('category')->distinct()->pluck('category');

        return view('public.overview', compact('videos', 'categories'));
    }
    
    /**
     * Public show page for a single video (QR scan target)
     */
    public function show(Video $video)
    {
        if (!$video->is_active) {
            abort(404);
        }
        
        return view('public.show', compact('video'));
    }

    /**
     * Show upload form
     */
    public function create()
    {
        return view('admin.upload');
    }

    /**
     * Store new video
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'video' => 'required|file|mimes:mp4,mkv,avi|max:204800', // 200MB
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120', // 5MB
            'category' => 'nullable|string|max:50',
            'description' => 'nullable|string|max:1000',
        ]);

        $videoPath = $request->file('video')->store('media/videos', 'public');
        
        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('media/thumbnails', 'public');
        }

        Video::create([
            'title' => $validated['title'],
            'file_path' => 'storage/' . $videoPath,
            'thumbnail_path' => $thumbnailPath ? 'storage/' . $thumbnailPath : null,
            'description' => $validated['description'] ?? null,
            'category' => $validated['category'] ?? 'General',
            'is_active' => true,
        ]);

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Video uploaded successfully.');
    }

    /**
     * Show edit form
     */
    public function edit(Video $video)
    {
        return view('admin.edit', compact('video'));
    }

    /**
     * Update video
     */
    public function update(Request $request, Video $video)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'video' => 'nullable|file|mimes:mp4,mkv,avi|max:204800',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'category' => 'nullable|string|max:50',
            'description' => 'nullable|string|max:1000',
        ]);

        // Replace video if new file uploaded
        if ($request->hasFile('video')) {
            $oldPath = str_replace('storage/', '', $video->file_path);
            if (Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
            $newPath = $request->file('video')->store('media/videos', 'public');
            $video->file_path = 'storage/' . $newPath;
        }

        // Replace thumbnail
        if ($request->hasFile('thumbnail')) {
            if ($video->thumbnail_path) {
                $oldThumb = str_replace('storage/', '', $video->thumbnail_path);
                if (Storage::disk('public')->exists($oldThumb)) {
                    Storage::disk('public')->delete($oldThumb);
                }
            }
            $newThumb = $request->file('thumbnail')->store('media/thumbnails', 'public');
            $video->thumbnail_path = 'storage/' . $newThumb;
        }

        $video->title = $validated['title'];
        $video->category = $validated['category'] ?? $video->category;
        $video->description = $validated['description'] ?? null;
        $video->save();

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Video updated successfully.');
    }

    /**
     * Delete video
     */
    public function destroy(Video $video)
    {
        $paths = [
            str_replace('storage/', '', $video->file_path),
            $video->thumbnail_path ? str_replace('storage/', '', $video->thumbnail_path) : null,
        ];

        foreach ($paths as $path) {
            if ($path && Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }

        $video->delete();

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Video deleted successfully.');
    }

    /**
     * Toggle status via AJAX or Redirect
     */
    public function toggleStatus(Video $video)
    {
        $video->is_active = !$video->is_active;
        $video->save();

        return back()->with('success', 'Status updated.');
    }

    /**
     * Track View (Increment)
     */
    public function trackView(Video $video)
    {
        $video->increment('views');
        return response()->json(['success' => true, 'views' => $video->views]);
    }
}
