<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Shops Digital Ads | Experience The Future</title>
    <link rel="shortcut icon" href="{{ asset('assets/logo_icon.png') }}" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #ffffff;
            color: #1e293b;
        }

        .hero-gradient {
            background: radial-gradient(circle at 50% 50%, #f1f5f9 0%, #ffffff 100%);
        }

        .video-card {
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .video-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.15);
        }

        .glass-nav {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
        }

        .category-pill {
            transition: all 0.3s ease;
        }

        .category-pill:hover {
            background-color: #0f172a;
            color: white;
            transform: scale(1.05);
        }

        .play-btn-anim {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.4);
            }

            70% {
                transform: scale(1.1);
                box-shadow: 0 0 0 20px rgba(255, 255, 255, 0);
            }

            100% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(255, 255, 255, 0);
            }
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
            justify-content: space-between;
            width: 100%;
            color: white;
        }

        .main-controls {
            display: flex;
            align-items: center;
            gap: 30px;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }

        .video-container:fullscreen {
            border-radius: 0;
            width: 100vw;
            height: 100vh;
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

<body class="antialiased" oncontextmenu="return false;">
    @csrf

    <!-- Elegant Navbar -->
    <nav class="fixed top-0 w-full z-50 glass-nav border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <img src="{{ asset('assets/logo.png') }}" class="h-10 w-auto" alt="Shops Digital Ads">
            </div>
            <div class="hidden md:flex items-center gap-8 text-sm font-bold tracking-tight uppercase text-slate-500">
                <a href="#" class="text-slate-900">Showcase</a>
                <a href="#about" class="hover:text-slate-900 transition-colors">Our Story</a>
                <a href="#vision" class="hover:text-slate-900 transition-colors">Impact</a>
            </div>
        </div>
    </nav>

    <!-- Interactive Hero -->
    <section class="pt-40 pb-20 hero-gradient overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <span
                class="inline-block px-4 py-1.5 rounded-full bg-slate-900 text-white text-[10px] font-black uppercase tracking-[0.3em] mb-6">Retail
                Ad Platform</span>
            <h1 class="text-6xl md:text-8xl font-black text-slate-900 tracking-tighter mb-8 leading-[0.9]">
                Capturing <span class="text-slate-400">Attention</span><br>Inside Local Retail.
            </h1>
            <p class="text-xl text-slate-500 font-medium max-w-2xl mx-auto mb-12">
                We transform the shopping experience through performance-focused digital creatives.
            </p>

            <!-- Filter Bar -->
            <div class="flex flex-wrap items-center justify-center gap-3 mt-12">
                <a href="{{ route('videos.index') }}"
                    class="category-pill px-8 py-3 rounded-2xl border border-slate-200 text-sm font-bold {{ !request('category') ? 'bg-slate-900 text-white' : 'bg-white' }}">
                    All Masterpieces
                </a>
                @foreach ($categories as $cat)
                    <a href="{{ route('videos.index', ['category' => $cat]) }}"
                        class="category-pill px-8 py-3 rounded-2xl border border-slate-200 text-sm font-bold {{ request('category') == $cat ? 'bg-slate-900 text-white' : 'bg-white' }}">
                        {{ $cat }}
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <main class="max-w-7xl mx-auto px-6 py-20">

        <!-- Search -->
        <div class="max-w-xl mx-auto mb-20 relative">
            <input type="text" name="search"
                onchange="window.location.href='{{ route('videos.index') }}?search='+this.value"
                value="{{ request('search') }}" placeholder="Search commercial archives..."
                class="w-full px-16 py-5 rounded-3xl border border-slate-200 bg-slate-50/50 focus:ring-8 focus:ring-slate-100 focus:border-slate-900 outline-none transition-all font-semibold italic text-slate-700">
            <svg class="absolute left-6 top-1/2 -translate-y-1/2 h-6 w-6 text-slate-400" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>

        <!-- Video Gallery Grid -->
        @if ($videos->count())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
                @foreach ($videos as $video)
                    <div
                        class="video-card group relative bg-white rounded-[2.5rem] overflow-hidden border border-slate-100">
                        <div class="relative aspect-video bg-slate-100 overflow-hidden cursor-pointer"
                            onclick="openPlayer('{{ asset($video->file_path) }}', '{{ $video->id }}', '{{ $video->title ?? '' }}', '{{ $video->description }}', '{{ $video->thumbnail_path ? asset($video->thumbnail_path) : '' }}')">
                            @if ($video->thumbnail_path)
                                <img src="{{ asset($video->thumbnail_path) }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000">
                            @else
                                <!-- Video Preview as Thumbnail Fallback -->
                                <video
                                    class="w-full h-full object-cover opacity-80 group-hover:opacity-100 transition-opacity"
                                    preload="metadata">
                                    <source src="{{ asset($video->file_path) }}#t=0.5">
                                </video>
                            @endif

                            <!-- Premium Play Button -->
                            <div
                                class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-500 scale-90 group-hover:scale-100 bg-slate-900/10">
                                <div
                                    class="w-20 h-20 bg-white shadow-2xl rounded-full flex items-center justify-center text-slate-900 play-btn-anim">
                                    <svg class="w-8 h-8 fill-current ml-1" viewBox="0 0 20 20">
                                        <path
                                            d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.333-5.89a1.5 1.5 0 000-2.538L6.3 2.841z" />
                                    </svg>
                                </div>
                            </div>

                            <div
                                class="absolute bottom-6 left-6 px-4 py-1.5 rounded-xl bg-white/90 backdrop-blur-md border border-slate-200">
                                <span
                                    class="text-[10px] font-black uppercase tracking-widest text-slate-900">{{ $video->category }}</span>
                            </div>
                        </div>

                        <div class="p-8">
                            @if ($video->title)
                                <h3 class="text-2xl font-black text-slate-900 mb-2 leading-tight">{{ $video->title }}
                                </h3>
                            @endif
                            <div
                                class="flex items-center justify-between text-slate-400 mt-4 pt-4 border-t border-slate-50">
                                <div class="flex items-center gap-2">
                                    <div class="w-2 h-2 rounded-full bg-green-500"></div>
                                    <span
                                        class="text-[10px] font-black uppercase tracking-widest">{{ $video->created_at->format('M Y') }}</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="2" />
                                        <path
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                    </svg>
                                    <span id="view-count-{{ $video->id }}"
                                        class="text-xs font-black text-slate-900">{{ number_format($video->views) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-32 bg-slate-50 rounded-[4rem] border-2 border-dashed border-slate-200">
                <h3 class="text-3xl font-black text-slate-900 mb-2">No Archived Content</h3>
                <p class="text-slate-500 font-medium">Retail masterpieces are being curated as we speak.</p>
            </div>
        @endif

        <!-- About Section -->
        <section id="about" class="mt-40">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-center">
                <div class="lg:col-span-12">
                    <h2 class="text-5xl font-black text-slate-900 mb-12 flex items-center gap-6">
                        <span class="p-4 bg-slate-900 rounded-[2rem] text-white">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </span>
                        About Shops Digital Ads
                    </h2>
                    <div
                        class="grid grid-cols-1 md:grid-cols-2 gap-12 text-slate-500 font-medium text-lg leading-[1.8]">
                        <p class="text-slate-900 font-bold text-2xl leading-tight">Founded in 2022, built on extensive
                            on-ground market experience and deep understanding of retail behavior.</p>
                        <p>Our platform connects brands directly with customers at the point where buying decisions are
                            made inside local retail stores. Formalized in September 2025 under Brando Digitech Pvt.
                            Ltd., we support large-scale professional expansion.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Vision/Mission Grid -->
        <section id="vision" class="mt-24 grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-slate-900 rounded-[3rem] p-12 text-white">
                <h3 class="text-3xl font-black mb-6">Our Vision</h3>
                <p class="text-slate-400 text-xl font-medium leading-relaxed">To build India’s most trusted retail
                    digital advertising network connecting brands, retailers, and customers through meaningful,
                    high-visibility advertising.</p>
            </div>
            <div class="bg-white rounded-[3rem] p-12 border-2 border-slate-100">
                <h3 class="text-3xl font-black text-slate-900 mb-6">Our Mission</h3>
                <ul class="space-y-4">
                    @foreach (['Help brands grow locally before scaling nationally.', 'Enable retailers to earn additional income.', 'Provide cost-effective advertising with real impact.', 'Strengthen brand recall at purchasing moments.'] as $item)
                        <li class="flex items-center gap-4 text-slate-600 font-bold">
                            <div class="w-2 h-2 bg-slate-900 rounded-full"></div>
                            {{ $item }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </section>

    </main>

    <!-- Video Modal -->
    <div id="playerModal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-white p-4 sm:p-20"
        onclick="closePlayer()">
        <button class="absolute top-10 right-10 text-slate-900 hover:rotate-90 transition-transform duration-500"
            onclick="closePlayer()">
            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
            </svg>
        </button>
        <div class="w-full max-w-6xl flex flex-col items-center gap-10" onclick="event.stopPropagation()">
            <div class="w-full video-container aspect-video rounded-[3rem] overflow-hidden bg-black shadow-2xl"
                id="playerContainer">
                <div class="video-click-area" onclick="togglePlay()"></div>
                <video id="mainVideo" class="w-full h-full" onplay="trackView()"></video>

                <div class="custom-controls" onclick="event.stopPropagation()">
                    <div class="progress-bar-container" id="progressBar">
                        <div class="progress-bar-fill" id="progressFill"></div>
                    </div>

                    <div class="control-btns">
                        <div class="flex items-center gap-4">
                            <!-- Placeholder for volume if needed later -->
                        </div>

                        <div class="main-controls">
                            <button onclick="togglePlay()"
                                class="bg-white text-black p-4 rounded-full hover:scale-110 transition-transform"
                                id="playBtn">
                                <svg id="playIcon" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8 5v14l11-7z" />
                                </svg>
                            </button>
                        </div>

                        <button onclick="toggleFullscreen()" class="hover:scale-110 transition-transform">
                            <svg id="fullscreenIcon" class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M7 14H5v5h5v-2H7v-3zm-2-4h2V7h3V5H5v5zm12 7h-3v2h5v-5h-2v3zM14 5v2h3v3h2V5h-5z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <div class="text-center max-w-4xl">
                <h2 id="modalTitle" class="text-5xl font-black text-slate-900 mb-4 tracking-tighter"></h2>
                <p id="modalDesc" class="text-slate-500 font-medium text-xl leading-relaxed"></p>
            </div>
        </div>
    </div>

    <!-- Minimalist Footer -->
    <footer class="mt-40 border-t border-slate-100 py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <div class="mb-12">
                <h3 class="text-3xl font-black text-slate-900 mb-1 leading-none">Sumit Chavhan</h3>
                <p class="text-xs font-black uppercase tracking-[0.4em] text-slate-400 mt-4">Founder & Visionary</p>
            </div>
            <p class="text-2xl text-slate-400 italic font-medium max-w-3xl mx-auto leading-relaxed">
                “Advertising delivers the strongest impact when brands meet customers at the exact moment purchasing
                decisions are made.”
            </p>
            <div
                class="mt-20 flex flex-col md:flex-row items-center justify-between gap-8 pt-10 border-t border-slate-200 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                <span>© {{ date('Y') }} BRANDO DIGITECH PVT. LTD.</span>
                <div class="flex gap-8">
                    <a href="#" class="hover:text-slate-900 transition-colors">Privacy</a>
                    <a href="#" class="hover:text-slate-900 transition-colors">Terms</a>
                    <a href="#" class="hover:text-slate-900 transition-colors">Contact</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        const video = document.getElementById('mainVideo');
        const playIcon = document.getElementById('playIcon');
        const progressFill = document.getElementById('progressFill');
        const progressBar = document.getElementById('progressBar');
        let currentVideoId = null;
        let viewTracked = false;

        function togglePlay() {
            if (video.paused) {
                video.play();
                playIcon.innerHTML = '<path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/>';
            } else {
                video.pause();
                playIcon.innerHTML = '<path d="M8 5v14l11-7z"/>';
            }
        }

        function toggleFullscreen() {
            const container = document.getElementById('playerContainer');
            const icon = document.getElementById('fullscreenIcon');

            if (!document.fullscreenElement) {
                container.requestFullscreen().catch(err => {
                    console.error(`Error attempting to enable full-screen mode: ${err.message}`);
                });
                icon.innerHTML =
                    '<path d="M5 16h3v3h2v-5H5v2zm3-8H5v2h5V5H8v3zm6 11h2v-3h3v-2h-5v5zm2-11V5h-2v5h5V8h-3z"/>';
            } else {
                document.exitFullscreen();
                icon.innerHTML =
                    '<path d="M7 14H5v5h5v-2H7v-3zm-2-4h2V7h3V5H5v5zm12 7h-3v2h5v-5h-2v3zM14 5v2h3v3h2V5h-5z"/>';
            }
        }

        // Update icon if exited via Esc key
        document.addEventListener('fullscreenchange', () => {
            const icon = document.getElementById('fullscreenIcon');
            if (icon && !document.fullscreenElement) {
                icon.innerHTML =
                    '<path d="M7 14H5v5h5v-2H7v-3zm-2-4h2V7h3V5H5v5zm12 7h-3v2h5v-5h-2v3zM14 5v2h3v3h2V5h-5z"/>';
            }
        });

        video.addEventListener('timeupdate', () => {
            const percent = (video.currentTime / video.duration) * 100;
            progressFill.style.width = percent + '%';
        });

        progressBar.addEventListener('click', (e) => {
            const scrubTime = (e.offsetX / progressBar.offsetWidth) * video.duration;
            video.currentTime = scrubTime;
        });

        function openPlayer(src, id, title, desc, poster) {
            currentVideoId = id;
            viewTracked = false;
            video.src = src;
            video.poster = poster || '';
            document.getElementById('modalTitle').innerText = title;
            document.getElementById('modalDesc').innerText = desc || 'Retail storytelling at its finest.';
            const modal = document.getElementById('playerModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            // Reset UI
            progressFill.style.width = '0%';
            playIcon.innerHTML = '<path d="M8 5v14l11-7z"/>';

            video.play();
        }

        function closePlayer() {
            video.pause();
            video.src = "";
            video.poster = "";
            document.getElementById('playerModal').classList.add('hidden');
            document.getElementById('playerModal').classList.remove('flex');
        }

        async function trackView() {
            if (viewTracked || !currentVideoId) return;
            try {
                await fetch(`/videos/${currentVideoId}/track-view`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                });
                viewTracked = true;
            } catch (err) {}
        }

        video.addEventListener('play', () => {
            playIcon.innerHTML = '<path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/>';
        });
        video.addEventListener('pause', () => {
            playIcon.innerHTML = '<path d="M8 5v14l11-7z"/>';
        });
    </script>
</body>

</html>
