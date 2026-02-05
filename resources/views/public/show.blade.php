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
        }
    </style>
</head>

<body class="antialiased min-h-screen hero-gradient">
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
            <!-- Video Player -->
            <div class="video-container aspect-video rounded-[3rem] overflow-hidden bg-black mb-12">
                <video id="mainVideo" class="w-full h-full" controls autoplay onplay="trackView()">
                    <source src="{{ asset($video->file_path) }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
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
        let viewTracked = false;
        const currentVideoId = "{{ $video->id }}";

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
                    document.getElementById('view-count').innerText = Number(data.views).toLocaleString() + ' Views';
                }
                viewTracked = true;
            } catch (err) {}
        }
    </script>
</body>

</html>
