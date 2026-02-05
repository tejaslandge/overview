<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Video Hub | Professional Dashboard</title>
    <link rel="shortcut icon" href="{{ asset('assets/logo_icon.png') }}" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f8fafc;
            color: #1e293b;
        }

        .card-shadow {
            box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.04), 0 0 10px -5px rgba(0, 0, 0, 0.02);
        }

        .glass-panel {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(226, 232, 240, 0.8);
        }

        .custom-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2364748b'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1.25rem center;
            background-size: 1rem;
        }

        /* Custom Video Player Styles */
        .video-container {
            position: relative;
            background: #000;
        }

        .custom-controls {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(transparent, rgba(0, 0, 0, 0.7));
            padding: 30px;
            opacity: 0;
            transition: opacity 0.3s ease;
            display: flex;
            flex-direction: column;
            gap: 15px;
            z-index: 20;
        }

        .video-container:hover .custom-controls {
            opacity: 1;
        }

        .progress-bar-container {
            width: 100%;
            height: 6px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            cursor: pointer;
            position: relative;
        }

        .progress-bar-fill {
            height: 100%;
            background: #fff;
            border-radius: 10px;
            width: 0%;
        }

        .control-btns {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 30px;
            color: white;
        }

        .video-container video::-webkit-media-controls {
            display: none !important;
        }

        video {
            pointer-events: none;
        }

        .video-click-area {
            position: absolute;
            inset: 0;
            z-index: 10;
        }
    </style>
</head>

<body class="min-h-screen antialiased" oncontextmenu="return false;">
    @csrf
    <main class="max-w-7xl mx-auto px-4 sm:px-8 py-10">

        <!-- Header Section -->
        <header class="flex flex-col lg:flex-row lg:items-center justify-between gap-8 mb-12">
            <div>
                <h1 class="text-4xl font-extrabold text-slate-900 tracking-tight">Campaign Manager</h1>
                <p class="text-slate-500 mt-2 font-medium">Manage, analyze and optimize your digital ads</p>
            </div>

            <div class="flex items-center gap-4">
                <a href="{{ route('admin.logs') }}"
                    class="px-6 py-4 rounded-2xl bg-white text-sm font-bold shadow-sm border border-slate-200 hover:shadow-md transition-all text-slate-700 flex items-center gap-2">
                    System Logs
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </a>
                <a href="{{ route('videos.index') }}" target="_blank"
                    class="px-6 py-4 rounded-2xl bg-white text-sm font-bold shadow-sm border border-slate-200 hover:shadow-md transition-all text-slate-700 flex items-center gap-2">
                    Live Overview
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                </a>
                <a href="{{ route('videos.create') }}"
                    class="px-8 py-4 rounded-2xl bg-slate-900 text-white text-sm font-bold shadow-xl hover:scale-105 transition-all">New
                    Campaign</a>
                <button onclick="openLogoutModal()"
                    class="px-6 py-4 rounded-2xl bg-red-50 text-red-600 text-sm font-bold hover:bg-red-100 transition-all">Logout</button>
            </div>
        </header>

        <!-- Filters & Search -->
        <section class="glass-panel rounded-[2.5rem] p-6 mb-12 shadow-sm">
            <form action="{{ route('admin.dashboard') }}" method="GET"
                class="flex flex-col md:flex-row items-center gap-5">
                <div class="relative flex-1 group w-full">
                    <svg class="absolute left-6 top-1/2 -translate-y-1/2 h-5 w-5 text-slate-400 group-focus-within:text-slate-900 transition-colors"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search by title or description..."
                        class="w-full pl-14 pr-6 py-4 rounded-2xl border border-slate-200 bg-slate-50/50 focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 outline-none transition-all font-medium">
                </div>

                <div class="flex items-center gap-4 w-full md:w-auto">
                    <div class="relative w-full md:w-56">
                        <select name="category" onchange="this.form.submit()"
                            class="custom-select w-full px-6 py-4 rounded-2xl border border-slate-200 bg-slate-50/50 text-sm font-bold text-slate-700 outline-none cursor-pointer focus:border-slate-900 transition-all">
                            <option value="">All Categories</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                                    {{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="relative w-full md:w-48">
                        <select name="status" onchange="this.form.submit()"
                            class="custom-select w-full px-6 py-4 rounded-2xl border border-slate-200 bg-slate-50/50 text-sm font-bold text-slate-700 outline-none cursor-pointer focus:border-slate-900 transition-all">
                            <option value="">All Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive
                            </option>
                        </select>
                    </div>
                </div>
            </form>
        </section>

        <!-- Video Grid -->
        @if ($videos->count())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                @foreach ($videos as $video)
                    <article
                        class="group bg-white rounded-[2.5rem] overflow-hidden card-shadow border border-slate-100/50 hover:border-slate-900/10 transition-all duration-500">
                        <!-- Media Preview -->
                        <div class="relative aspect-video bg-slate-900 overflow-hidden cursor-pointer"
                            onclick="openPreviewModal('{{ asset($video->file_path) }}', '{{ $video->title }}', '{{ $video->description }}')">
                            @if ($video->thumbnail_path)
                                <img src="{{ asset($video->thumbnail_path) }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            @else
                                <video class="w-full h-full object-cover opacity-80" muted preload="metadata">
                                    <source src="{{ asset($video->file_path) }}">
                                </video>
                            @endif

                            <!-- Badges -->
                            <div class="absolute top-6 left-6 flex gap-2">
                                <span
                                    class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest {{ $video->is_active ? 'bg-emerald-500 text-white' : 'bg-slate-500 text-white' }}">
                                    {{ $video->is_active ? 'Active' : 'Hidden' }}
                                </span>
                                <span
                                    class="bg-white/90 backdrop-blur-md px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest text-slate-900 shadow-sm">
                                    {{ $video->category }}
                                </span>
                            </div>

                            <!-- View Count Overlay -->
                            <div
                                class="absolute bottom-6 right-6 bg-black/60 backdrop-blur-md px-4 py-2 rounded-2xl flex items-center gap-2">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <span class="text-white text-xs font-bold">{{ number_format($video->views) }}</span>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-8">
                            <h3 class="text-xl font-extrabold text-slate-900 line-clamp-1 mb-2">
                                {{ $video->title ?? 'Untitled Campaign' }}</h3>
                            <p class="text-sm text-slate-500 line-clamp-2 font-medium mb-8 leading-relaxed">
                                {{ $video->description }}</p>

                            <div class="flex items-center justify-between pt-6 border-t border-slate-50">
                                <div class="flex items-center gap-3">
                                    <a href="{{ route('videos.edit', $video->id) }}"
                                        class="p-3 rounded-xl bg-slate-50 text-slate-600 hover:bg-slate-900 hover:text-white transition-all shadow-sm">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('videos.toggle-status', $video->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="p-3 rounded-xl {{ $video->is_active ? 'bg-amber-50 text-amber-600' : 'bg-emerald-50 text-emerald-600' }} hover:scale-105 transition-transform shadow-sm">
                                            @if ($video->is_active)
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                                                </svg>
                                            @else
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            @endif
                                        </button>
                                    </form>
                                    <button
                                        onclick="openQRModal('{{ url('/videos/' . $video->id) }}', '{{ $video->title }}')"
                                        class="p-3 rounded-xl bg-blue-50 text-blue-600 hover:scale-105 transition-transform shadow-sm">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                        </svg>
                                    </button>
                                </div>
                                <button onclick="openDeleteModal('{{ route('videos.destroy', $video->id) }}')"
                                    class="text-sm font-bold text-red-500 hover:text-red-700 transition-colors">Delete</button>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <section class="bg-white rounded-[2.5rem] p-20 text-center shadow-sm border border-slate-100">
                <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" />
                    </svg>
                </div>
                <h2 class="text-2xl font-black text-slate-900">No campaigns found</h2>
                <p class="text-slate-500 mt-2 font-medium">Try adjusting your filters or launch a new campaign</p>
            </section>
        @endif
    </main>

    <!-- QR Modal -->
    <div id="qrModal"
        class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/60 backdrop-blur-md p-6"
        onclick="closeQRModal()">
        <div class="bg-white w-full max-w-sm rounded-[2.5rem] shadow-2xl p-10 text-center"
            onclick="event.stopPropagation()">
            <h2 id="qrTitle" class="text-2xl font-black text-slate-900 mb-6">Campaign QR</h2>
            <div class="bg-slate-50 p-6 rounded-[2rem] inline-block mb-8 shadow-inner">
                <img id="qrImage" src="" alt="QR Code" class="w-48 h-48">
            </div>
            <p class="text-slate-500 text-sm font-medium mb-8">Scan to view this campaign instantly on mobile</p>
            <button onclick="closeQRModal()"
                class="w-full py-4 rounded-2xl bg-slate-900 text-white text-sm font-black uppercase tracking-widest">Close</button>
        </div>
    </div>

    <!-- Delete Modal -->
    <div id="deleteModal"
        class="fixed inset-0 z-50 hidden items-center justify-center bg-red-900/20 backdrop-blur-md p-6"
        onclick="closeDeleteModal()">
        <div class="bg-white w-full max-w-md rounded-[2.5rem] shadow-2xl p-10" onclick="event.stopPropagation()">
            <div class="w-16 h-16 bg-red-50 rounded-2xl flex items-center justify-center mb-6">
                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </div>
            <h2 class="text-2xl font-black text-slate-900 mb-2">Delete Campaign?</h2>
            <p class="text-slate-500 font-medium mb-8 text-sm leading-relaxed">This will permanently remove the video,
                views and analytics. This action cannot be undone.</p>
            <div class="flex flex-col sm:flex-row gap-4">
                <button onclick="closeDeleteModal()"
                    class="flex-1 py-4 rounded-2xl bg-slate-100 text-slate-600 text-xs font-black uppercase">Keep
                    it</button>
                <form id="deleteForm" method="POST" action="" class="flex-1">
                    @csrf @method('DELETE')
                    <button type="submit"
                        class="w-full py-4 rounded-2xl bg-red-600 text-white text-xs font-black uppercase shadow-lg shadow-red-600/20">Delete
                        Forever</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Logout Modal -->
    <div id="logoutModal"
        class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/40 backdrop-blur-md p-6"
        onclick="closeLogoutModal()">
        <div class="bg-white w-full max-w-sm rounded-[2.5rem] shadow-2xl p-10 text-center"
            onclick="event.stopPropagation()">
            <h2 class="text-2xl font-black text-slate-900 mb-2">Signing Out?</h2>
            <p class="text-slate-500 font-medium mb-8">Are you sure you want to end your current session?</p>
            <div class="flex flex-col gap-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full py-4 rounded-2xl bg-slate-900 text-white text-sm font-black uppercase tracking-widest">Yes,
                        Sign Out</button>
                </form>
                <button onclick="closeLogoutModal()"
                    class="w-full py-4 rounded-2xl bg-slate-100 text-slate-600 text-xs font-black uppercase">Stay
                    Logged In</button>
            </div>
        </div>
    </div>

    <!-- Preview Modal -->
    <div id="previewModal"
        class="fixed inset-0 z-50 hidden flex-col items-center justify-center bg-slate-900/90 backdrop-blur-xl p-4 sm:p-10"
        onclick="closePreviewModal()">
        <button
            class="absolute top-8 right-8 text-white/50 hover:text-white transition-all hover:rotate-90 duration-300"
            onclick="closePreviewModal()">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" />
            </svg>
        </button>

        <div class="w-full max-w-5xl flex flex-col items-center gap-8" onclick="event.stopPropagation()">
            <div
                class="w-full video-container aspect-video rounded-3xl overflow-hidden bg-black shadow-2xl ring-1 ring-white/10">
                <div class="video-click-area" onclick="togglePlay()"></div>
                <video id="previewVideo" class="w-full h-full"></video>

                <div class="custom-controls" onclick="event.stopPropagation()">
                    <div class="progress-bar-container" id="progressBar">
                        <div class="progress-bar-fill" id="progressFill"></div>
                    </div>

                    <div class="control-btns">
                        <button onclick="skip(-10)" class="hover:scale-110 transition-transform">
                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12.5 3c-4.97 0-9 4.03-9 9H1l3.89 3.89.07.14L9 12H6c0-3.31 2.69-6 6-6s6 2.69 6 6-2.69 6-6 6c-1.66 0-3.14-.69-4.22-1.78L6.37 17.63C7.81 19.08 9.8 20 12 20c4.42 0 8-3.58 8-8s-3.58-8-8-8zm-.5 11V9l-3.5 2.5 3.5 2.5z" />
                            </svg>
                        </button>

                        <button onclick="togglePlay()"
                            class="bg-white text-black p-4 rounded-full hover:scale-110 transition-transform"
                            id="playBtn">
                            <svg id="playIcon" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8 5v14l11-7z" />
                            </svg>
                        </button>

                        <button onclick="skip(10)" class="hover:scale-110 transition-transform">
                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M11.5 3c4.97 0 9 4.03 9 9H23l-3.89 3.89-.07.14L15 12h3c0-3.31-2.69-6-6-6s-6 2.69-6 6 2.69 6 6 6c1.66 0 3.14-.69 4.22-1.78l1.41 1.41C16.19 19.08 14.2 20 12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8zm.5 11V9l3.5 2.5-3.5 2.5z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <div class="text-center max-w-4xl">
                <h2 id="previewTitle" class="text-3xl font-black text-white mb-2 tracking-tight"></h2>
                <p id="previewDesc" class="text-slate-400 font-medium text-lg leading-relaxed"></p>
            </div>
        </div>
    </div>

    <script>
        const video = document.getElementById('previewVideo');
        const playIcon = document.getElementById('playIcon');
        const progressFill = document.getElementById('progressFill');
        const progressBar = document.getElementById('progressBar');

        function togglePlay() {
            if (video.paused) {
                video.play();
                playIcon.innerHTML = '<path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/>';
            } else {
                video.pause();
                playIcon.innerHTML = '<path d="M8 5v14l11-7z"/>';
            }
        }

        function skip(time) {
            video.currentTime += time;
        }

        video.addEventListener('timeupdate', () => {
            const percent = (video.currentTime / video.duration) * 100;
            progressFill.style.width = percent + '%';
        });

        progressBar.addEventListener('click', (e) => {
            const scrubTime = (e.offsetX / progressBar.offsetWidth) * video.duration;
            video.currentTime = scrubTime;
        });

        function openPreviewModal(src, title, desc) {
            video.src = src;
            document.getElementById('previewTitle').innerText = title || 'Untitled Campaign';
            document.getElementById('previewDesc').innerText = desc || 'No description available.';
            const modal = document.getElementById('previewModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            // Reset UI
            progressFill.style.width = '0%';
            playIcon.innerHTML = '<path d="M8 5v14l11-7z"/>';

            video.play();
        }

        function closePreviewModal() {
            video.pause();
            video.src = "";
            const modal = document.getElementById('previewModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        video.addEventListener('play', () => {
            playIcon.innerHTML = '<path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/>';
        });
        video.addEventListener('pause', () => {
            playIcon.innerHTML = '<path d="M8 5v14l11-7z"/>';
        });

        function openQRModal(url, title) {
            document.getElementById('qrTitle').innerText = title || 'Campaign';
            document.getElementById('qrImage').src =
                `https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=${encodeURIComponent(url)}`;
            const modal = document.getElementById('qrModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeQRModal() {
            const modal = document.getElementById('qrModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function openDeleteModal(action) {
            document.getElementById('deleteForm').action = action;
            const modal = document.getElementById('deleteModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeDeleteModal() {
            const modal = document.getElementById('deleteModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

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

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeQRModal();
                closeDeleteModal();
                closeLogoutModal();
                closePreviewModal();
            }
        });
    </script>
</body>

</html>
