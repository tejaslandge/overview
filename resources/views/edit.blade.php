<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Campaign | Premium Experience</title>
    <link rel="shortcut icon" href="{{ asset('assets/logo_icon.png') }}" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f8fafc;
            transition: background-color 0.3s ease;
        }

        .dark body {
            background: #0f172a;
            color: #f8fafc;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
        }

        .dark .glass-card {
            background: rgba(30, 41, 59, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .progress-bar {
            transition: width 0.3s ease-out;
        }
    </style>
</head>

<body class="min-h-screen antialiased">

    <main class="min-h-screen flex items-center justify-center p-4 sm:p-10">

        <section class="w-full max-w-5xl glass-card rounded-[2.5rem] shadow-2xl p-8 sm:p-12 relative overflow-hidden">

            <!-- Dark Mode Toggle -->
            <button onclick="toggleDarkMode()"
                class="absolute top-8 right-8 p-3 rounded-2xl bg-slate-100 dark:bg-slate-800 transition-colors">
                <svg id="moonIcon" xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6 text-slate-700 dark:text-slate-200" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                </svg>
            </button>

            <!-- Header -->
            <div class="mb-12 flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight">Edit Campaign</h1>
                    <p class="text-slate-500 dark:text-slate-400 mt-2 font-medium">Updating: {{ $video->title }}</p>
                </div>
            </div>

            <!-- Form -->
            <form id="editForm" method="POST" action="{{ route('videos.update', $video->id) }}"
                enctype="multipart/form-data" class="space-y-12">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">

                    <!-- Left: Media Section -->
                    <div class="space-y-8">
                        <!-- Current Video -->
                        <div class="space-y-3">
                            <label class="text-sm font-bold text-slate-700 dark:text-slate-300 ml-1">Current Active
                                Video</label>
                            <div
                                class="relative rounded-[2rem] overflow-hidden bg-black aspect-video shadow-xl ring-4 ring-white dark:ring-slate-800">
                                <video id="currentVideo" class="w-full h-full" controls>
                                    <source src="{{ asset($video->file_path) }}">
                                </video>
                            </div>
                            <label class="block mt-4 cursor-pointer">
                                <span
                                    class="bg-slate-900 dark:bg-white text-white dark:text-slate-900 px-6 py-3 rounded-xl text-xs font-bold uppercase tracking-widest inline-block hover:scale-105 transition-transform">Replace
                                    Video File</span>
                                <input type="file" id="videoInput" name="video" class="hidden" accept="video/*" />
                            </label>
                            <div id="videoNameDisplay"
                                class="mt-2 text-xs font-bold text-blue-600 bg-blue-50 px-3 py-1 rounded-full hidden">
                            </div>
                        </div>

                        <!-- Thumbnail -->
                        <div class="space-y-3">
                            <label class="text-sm font-bold text-slate-700 dark:text-slate-300 ml-1">Custom
                                Thumbnail</label>
                            <div class="flex items-center gap-6">
                                <div id="thumbPreview"
                                    class="w-32 h-32 rounded-3xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center overflow-hidden border-2 border-slate-200 dark:border-slate-700">
                                    @if ($video->thumbnail_path)
                                        <img src="{{ asset($video->thumbnail_path) }}"
                                            class="w-full h-full object-cover">
                                    @else
                                        <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    @endif
                                </div>
                                <label
                                    class="flex-1 cursor-pointer bg-white dark:bg-slate-800 border-2 border-slate-200 dark:border-slate-700 px-8 py-6 rounded-3xl text-sm font-bold text-slate-600 dark:text-slate-400 hover:bg-slate-50 transition-all text-center">
                                    <span>Update Thumbnail</span>
                                    <input type="file" id="thumbInput" name="thumbnail" class="hidden"
                                        accept="image/*" />
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Info Section -->
                    <div class="space-y-10">
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-700 dark:text-slate-300 ml-1">Campaign
                                Title</label>
                            <input type="text" name="title" value="{{ $video->title }}" required
                                class="w-full rounded-[1.5rem] border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/50 px-6 py-5 text-sm font-medium focus:ring-2 focus:ring-slate-900/5 focus:border-slate-900 dark:focus:border-white transition-all outline-none">
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-700 dark:text-slate-300 ml-1">Category</label>
                            <select name="category"
                                class="w-full rounded-[1.5rem] border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/50 px-6 py-5 text-sm font-medium focus:ring-2 focus:ring-slate-900/5 focus:border-slate-900 dark:focus:border-white transition-all outline-none appearance-none">
                                <option value="General" {{ $video->category == 'General' ? 'selected' : '' }}>General
                                </option>
                                <option value="Food & Drink" {{ $video->category == 'Food & Drink' ? 'selected' : '' }}>
                                    Food & Drink</option>
                                <option value="Fashion" {{ $video->category == 'Fashion' ? 'selected' : '' }}>Fashion
                                </option>
                                <option value="Electronics" {{ $video->category == 'Electronics' ? 'selected' : '' }}>
                                    Electronics</option>
                                <option value="Real Estate" {{ $video->category == 'Real Estate' ? 'selected' : '' }}>
                                    Real Estate</option>
                                <option value="Services" {{ $video->category == 'Services' ? 'selected' : '' }}>
                                    Services</option>
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-700 dark:text-slate-300 ml-1">Description</label>
                            <textarea name="description" rows="6"
                                class="w-full rounded-[1.5rem] border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/50 px-6 py-5 text-sm font-medium focus:ring-2 focus:ring-slate-900/5 focus:border-slate-900 dark:focus:border-white transition-all outline-none resize-none">{{ $video->description }}</textarea>
                        </div>

                        <!-- Progress (Only if video replaced) -->
                        <div id="progressContainer" class="hidden space-y-4 pt-4 animate-in fade-in">
                            <div class="flex justify-between items-end">
                                <span id="progressStatus"
                                    class="text-lg font-bold text-slate-900 dark:text-white">Pushing Updates...</span>
                                <span id="progressPercent"
                                    class="text-3xl font-black text-slate-900 dark:text-white">0%</span>
                            </div>
                            <div
                                class="w-full bg-slate-100 dark:bg-slate-800 rounded-full h-4 overflow-hidden border border-slate-200 dark:border-slate-700">
                                <div id="progressBar"
                                    class="progress-bar w-0 h-full bg-slate-900 dark:bg-white rounded-full"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="pt-12 border-t border-slate-100 dark:border-slate-800 flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex-1 px-8 py-5 rounded-[2rem] text-sm font-bold text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all text-center">Cancel</a>
                    <button type="submit" id="submitBtn"
                        class="flex-[2] bg-slate-900 dark:bg-white text-white dark:text-slate-900 py-5 rounded-[2rem] text-sm font-black tracking-widest uppercase hover:shadow-2xl hover:shadow-slate-900/40 transition-all">Save
                        Changes</button>
                </div>

            </form>

        </section>

    </main>

    <script>
        const editForm = document.getElementById('editForm');
        const videoInput = document.getElementById('videoInput');
        const thumbInput = document.getElementById('thumbInput');
        const currentVideo = document.getElementById('currentVideo');
        const thumbPreview = document.getElementById('thumbPreview');
        const progressContainer = document.getElementById('progressContainer');
        const progressBar = document.getElementById('progressBar');
        const progressPercent = document.getElementById('progressPercent');
        const progressStatus = document.getElementById('progressStatus');
        const submitBtn = document.getElementById('submitBtn');
        const videoNameDisplay = document.getElementById('videoNameDisplay');

        videoInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const url = URL.createObjectURL(file);
                currentVideo.src = url;
                videoNameDisplay.innerText = "Target: " + file.name;
                videoNameDisplay.classList.remove('hidden');
                currentVideo.play();
            }
        });

        thumbInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const url = URL.createObjectURL(file);
                thumbPreview.innerHTML = `<img src="${url}" class="w-full h-full object-cover">`;
            }
        });

        // Dark Mode Logic
        function toggleDarkMode() {
            document.documentElement.classList.toggle('dark');
            const isDark = document.documentElement.classList.contains('dark');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
        }

        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark');
        }

        editForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(editForm);
            const xhr = new XMLHttpRequest();

            xhr.upload.addEventListener('progress', (e) => {
                if (e.lengthComputable) {
                    const percent = Math.round((e.loaded / e.total) * 100);
                    progressBar.style.width = percent + '%';
                    progressPercent.innerText = percent + '%';
                    progressStatus.innerText = percent < 100 ? 'Syncing Media...' : 'Finalizing Updates...';
                }
            });

            progressContainer.classList.remove('hidden');
            submitBtn.disabled = true;
            submitBtn.innerText = 'Syncing...';

            xhr.onload = function() {
                if (xhr.status === 200 || xhr.responseURL.includes('overview') || xhr.responseURL.includes(
                        'dashboard')) {
                    progressStatus.innerText = 'Updated Successfully!';
                    setTimeout(() => window.location.href = "{{ route('admin.dashboard') }}", 1000);
                } else {
                    alert('Error: ' + xhr.responseText);
                    submitBtn.disabled = false;
                }
            };

            xhr.open('POST', editForm.action, true);
            xhr.send(formData);
        });
    </script>

</body>

</html>
