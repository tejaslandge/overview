<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    /**
     * Admin dashboard view
     */
    public function index()
    {
        $videos = Video::latest()->get();
        return view('dashboard', compact('videos'));
    }

    /**
     * Public overview page (client-facing)
     */
    public function overview()
    {
        $videos = Video::latest()->get();
        return view('overview', compact('videos'));
    }

    /**
     * Show upload form
     */
    public function create()
    {
        return view('upload');
    }

    /**
     * Store new video
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'video' => 'required|file|mimes:mp4,mkv,avi|max:102400', // 100MB
            'description' => 'nullable|string|max:1000',
        ]);

        $path = $validated['video']->store('media/overview', 'public');

        Video::create([
            'file_path' => 'storage/' . $path,
            'description' => $validated['description'] ?? null,
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
        return view('edit', compact('video'));
    }

    /**
     * Update video
     */
    public function update(Request $request, Video $video)
    {
        $validated = $request->validate([
            'video' => 'nullable|file|mimes:mp4,mkv,avi|max:102400', // 100MB
            'description' => 'nullable|string|max:1000',
        ]);

        // Replace video if new file uploaded
        if ($request->hasFile('video')) {

            $oldPath = str_replace('storage/', '', $video->file_path);

            if (Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }

            $newPath = $validated['video']->store('media/overview', 'public');
            $video->file_path = 'storage/' . $newPath;
        }

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
        $path = str_replace('storage/', '', $video->file_path);

        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }

        $video->delete();

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Video deleted successfully.');
    }
}
