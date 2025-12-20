<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ asset('assets/logo_icon.png') }}" type="image/png">

    <title>Shops Digital Ads</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-100 min-h-screen text-slate-800">

    <main class="max-w-6xl mx-auto px-4 sm:px-6 py-8">

        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">

            <div>
                <h1 class="text-2xl font-semibold tracking-tight">
                    Video Management
                </h1>
                <p class="text-sm text-slate-500 mt-1">
                    Upload, review, and manage client videos
                </p>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-3">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center gap-2
               text-sm font-medium
               text-slate-600
               px-4 py-2.5 rounded-lg
               hover:text-red-600 hover:bg-red-50
               transition">
                        ⎋ Logout
                    </button>
                </form>


                <a href="{{ route('videos.index') }}"
                    class="inline-flex items-center
                          border border-slate-300
                          text-slate-700 text-sm font-medium
                          px-4 py-2.5 rounded-lg
                          hover:bg-slate-100 transition">
                    Overview
                </a>

                <a href="/upload"
                    class="inline-flex items-center
                          bg-slate-800 text-white text-sm font-medium
                          px-4 py-2.5 rounded-lg
                          hover:bg-slate-900 transition">
                    Upload Video
                </a>
            </div>

        </div>

        <!-- Video List -->
        @if ($videos->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                @foreach ($videos as $video)
                    <div class="bg-white rounded-xl border shadow-sm hover:shadow-md transition overflow-hidden">

                        <!-- Video -->
                        <div class="bg-black">
                            <video class="w-full aspect-video" controls preload="metadata">
                                <source src="{{ asset($video->file_path) }}">
                            </video>
                        </div>

                        <!-- Content -->
                        <div class="p-4">

                            <p class="text-sm text-slate-700 leading-relaxed line-clamp-3 mb-4">
                                {{ $video->description ?? 'No description provided.' }}
                            </p>

                            <!-- Actions -->
                            <div class="flex items-center justify-between pt-3 border-t text-sm">

                                <a href="{{ route('videos.edit', $video->id) }}"
                                    class="text-slate-600 hover:text-slate-900 font-medium">
                                    Edit
                                </a>

                                <form method="POST" action="{{ route('videos.destroy', $video->id) }}"
                                    onsubmit="return confirm('Delete this video?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="text-slate-500 hover:text-red-600 font-medium">
                                        Delete
                                    </button>
                                </form>

                            </div>

                        </div>
                    </div>
                @endforeach

            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-xl border shadow-sm p-12 text-center">
                <h3 class="text-base font-semibold mb-1">
                    No Videos Uploaded
                </h3>
                <p class="text-sm text-slate-500">
                    Uploaded client videos will appear here.
                </p>
            </div>
        @endif

    </main>

</body>

</html>
