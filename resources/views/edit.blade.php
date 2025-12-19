<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <!-- REQUIRED for mobile responsiveness -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Shops Digital Ads – Edit Video</title>

    <meta http-equiv="Content-Security-Policy" content="script-src 'self' https://cdn.tailwindcss.com;">

    <link rel="shortcut icon" href="{{ asset('assets/logo_icon.png') }}" type="image/png">

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-100 min-h-screen flex items-start justify-center">

    <main class="w-full max-w-2xl px-4 sm:px-6 py-10">

        <!-- Page Header -->
        <div class="mb-8 text-center sm:text-left">
            <h2 class="text-2xl sm:text-3xl font-bold text-slate-800">
                Edit Video
            </h2>
            <p class="text-slate-500 mt-1 text-sm sm:text-base">
                Update the video file or adjust its description
            </p>
        </div>

        <!-- Form Card -->
        <form
            method="POST"
            action="{{ route('videos.update', $video->id) }}"
            enctype="multipart/form-data"
            class="bg-white rounded-2xl shadow-md p-6 sm:p-8 space-y-6"
        >
            @csrf
            @method('PUT')

            <!-- Current Video -->
            <div>
                <p class="text-sm font-medium text-slate-600 mb-2">
                    Current Video
                </p>
                <div class="bg-black rounded-xl overflow-hidden ring-1 ring-slate-200">
                    <video class="w-full aspect-video" controls preload="metadata">
                        <source src="{{ asset($video->file_path) }}">
                        Your browser does not support the video tag.
                    </video>
                </div>
            </div>

            <!-- Replace Video -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">
                    Replace Video <span class="text-slate-400">(optional)</span>
                </label>
                <input
                    type="file"
                    name="video"
                    accept="video/*"
                    class="block w-full text-sm text-slate-600
                           file:mr-4 file:py-2 file:px-4
                           file:rounded-lg file:border-0
                           file:bg-slate-800 file:text-white
                           hover:file:bg-slate-900
                           transition"
                >
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">
                    Description
                </label>
                <textarea
                    name="description"
                    rows="4"
                    placeholder="Add or update the video description..."
                    class="w-full rounded-lg border-slate-300 shadow-sm
                           focus:border-blue-500 focus:ring-blue-500 resize-none"
                >{{ $video->description }}</textarea>
            </div>

            <!-- Actions -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-end gap-3 pt-2">
                <a
                    href="{{ route('admin.dashboard') }}"
                    class="text-sm text-slate-600 hover:text-slate-800 text-center"
                >
                    Cancel
                </a>

                <button
                    type="submit"
                    class="bg-blue-600 text-white text-sm font-medium px-6 py-2.5 rounded-lg
                           hover:bg-blue-700 transition shadow-sm"
                >
                    Update Video
                </button>
            </div>
        </form>

    </main>

</body>
</html>
