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

                <!-- Logout Trigger (NO FORM) -->
                <button onclick="openLogoutModal()"
                    class="inline-flex items-center gap-2
                           text-sm font-medium
                           text-slate-600
                           px-4 py-2.5 rounded-lg
                           hover:text-red-600 hover:bg-red-50
                           transition">
                    ⎋ Logout
                </button>

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

                        <div class="bg-black">
                            <video class="w-full aspect-video" controls preload="metadata">
                                <source src="{{ asset($video->file_path) }}">
                            </video>
                        </div>

                        <div class="p-4">
                            <p class="text-sm text-slate-700 leading-relaxed line-clamp-3 mb-4">
                                {{ $video->description ?? 'No description provided.' }}
                            </p>

                            <div class="flex items-center justify-between pt-3 border-t text-sm">
                                <a href="{{ route('videos.edit', $video->id) }}"
                                    class="text-slate-600 hover:text-slate-900 font-medium">
                                    Edit
                                </a>

                                <form method="POST" action="{{ route('videos.destroy', $video->id) }}"
                                    onsubmit="return confirm('Delete this video?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-slate-500 hover:text-red-600 font-medium">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                @endforeach

            </div>
        @else
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

    <!-- Logout Modal -->
    <div id="logoutModal"
         class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 backdrop-blur-sm"
         onclick="closeLogoutModal()">

        <div class="bg-white w-full max-w-md rounded-xl shadow-xl p-6"
             onclick="event.stopPropagation()">

            <h2 class="text-lg font-semibold text-slate-800">
                Confirm Logout
            </h2>

            <p class="text-sm text-slate-500 mt-2">
                Are you sure you want to log out? You’ll need to sign in again.
            </p>

            <div class="flex justify-end gap-3 mt-6">

                <button onclick="closeLogoutModal()"
                    class="px-4 py-2 rounded-lg text-sm font-medium
                           text-slate-600 hover:bg-slate-100 transition">
                    Cancel
                </button>

                <!-- SINGLE Logout Form -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="px-4 py-2 rounded-lg text-sm font-medium
                               bg-red-600 text-white
                               hover:bg-red-700 transition">
                        Logout
                    </button>
                </form>

            </div>
        </div>
    </div>

    <script>
        function openLogoutModal() {
            const modal = document.getElementById('logoutModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeLogoutModal() {
            const modal = document.getElementById('logoutModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeLogoutModal();
            }
        });
    </script>

</body>
</html>
