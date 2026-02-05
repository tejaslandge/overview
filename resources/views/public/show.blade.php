<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $video->title }} | Shops Digital Ads</title>
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

        .glass-nav {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
        }

        .video-container {
            box-shadow: 0 50px 100px -20px rgba(0, 0, 0, 0.25);
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

        /* Prevent right click */
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

<body class="antialiased min-h-screen hero-gradient" oncontextmenu="return false;">
    @csrf

    <!-- Simple Navbar -->
    <nav class="fixed top-0 w-full z-50 glass-nav border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <a href="{{ route('videos.index') }}" class="flex items-center gap-3 hover:opacity-80 transition-opacity">
                <img src="{{ asset('assets/logo.png') }}" class="h-10 w-auto" alt="Shops Digital Ads">
            </a>
            <a href="{{ route('videos.index') }}"
                class="text-xs font-black uppercase tracking-widest text-slate-400 hover:text-slate-900 transition-colors">
                Back to Gallery
            </a>
        </div>
    </nav>

    <main class="pt-40 pb-20 px-6">
        <div class="max-w-5xl mx-auto">
            <!-- Custom Video Player -->
            <div class="video-container aspect-video rounded-[3rem] overflow-hidden bg-black mb-12"
                id="playerContainer">
                <div class="video-click-area" onclick="togglePlay()"></div>
                <video id="mainVideo" class="w-full h-full" autoplay onplay="trackView()">
                    <source src="{{ asset($video->file_path) }}" type="video/mp4">
                </video>

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

            <!-- Content Header -->
            <div class="flex flex-col md:flex-row md:items-start justify-between gap-8">
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-6">
                        <span
                            class="px-4 py-1.5 rounded-full bg-slate-900 text-white text-[10px] font-black uppercase tracking-widest">
                            {{ $video->category }}
                        </span>
                        <div class="flex items-center gap-1.5 text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <span id="view-count"
                                class="text-xs font-black text-slate-900">{{ number_format($video->views) }}
                                Views</span>
                        </div>
                    </div>
                    <h1 class="text-4xl md:text-6xl font-black text-slate-900 tracking-tighter mb-6 leading-tight">
                        {{ $video->title }}
                    </h1>
                    <p class="text-xl text-slate-500 font-medium leading-relaxed max-w-3xl">
                        {{ $video->description ?: 'Experience the future of retail advertising with this high-impact creative masterpiece.' }}
                    </p>
                </div>

                <!-- founder/Contact Mini Card -->
                <div class="w-full md:w-80 p-8 rounded-[2.5rem] bg-slate-50 border border-slate-100">
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-4">Presented By</p>
                    <h3 class="text-xl font-black text-slate-900 mb-1">Sumit Chavhan</h3>
                    <p class="text-sm font-bold text-slate-500 mb-6">Founder, Shops Digital Ads</p>
                    <a href="{{ route('videos.index') }}"
                        class="inline-flex w-full items-center justify-center py-4 rounded-2xl bg-slate-900 text-white text-xs font-black uppercase tracking-widest hover:scale-105 transition-all">
                        View All Archives
                    </a>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="py-20 border-t border-slate-100 bg-white">
        <div
            class="max-w-7xl mx-auto px-6 text-center text-[10px] font-black text-slate-400 uppercase tracking-[0.3em]">
            © {{ date('Y') }} BRANDO DIGITECH PVT. LTD. — ALL RIGHTS RESERVED
        </div>
    </footer>

    <script>
        const video = document.getElementById('mainVideo');
        const playIcon = document.getElementById('playIcon');
        const progressFill = document.getElementById('progressFill');
        const progressBar = document.getElementById('progressBar');
        let viewTracked = false;
        const currentVideoId = "{{ $video->id }}";

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
            if (!document.fullscreenElement) {
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

        async function trackView() {
            if (viewTracked || !currentVideoId) return;
            try {
                const response = await fetch(`/videos/${currentVideoId}/track-view`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                });
                const data = await response.json();
                if (data.success) {
                    const viewCountEl = document.getElementById('view-count');
                    if (viewCountEl) {
                        viewCountEl.innerText = Number(data.views).toLocaleString() + ' Views';
                    }
                }
                viewTracked = true;
            } catch (err) {}
        }

        // Initialize play icon on load
        video.addEventListener('play', () => {
            playIcon.innerHTML = '<path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/>';
        });
        video.addEventListener('pause', () => {
            playIcon.innerHTML = '<path d="M8 5v14l11-7z"/>';
        });
    </script>
</body>

</html>
