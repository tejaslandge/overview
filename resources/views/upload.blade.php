<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Advanced Upload | Premium Experience</title>
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

        <section class="w-full max-w-4xl glass-card rounded-[2.5rem] shadow-2xl p-8 sm:p-12 relative overflow-hidden">

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
            <div class="mb-12 text-center">
                <div
                    class="inline-flex items-center justify-center w-20 h-20 bg-slate-900 dark:bg-white rounded-3xl mb-6 shadow-2xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white dark:text-slate-900"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                </div>
                <h1 class="text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight">Add New Campaign</h1>
                <p class="text-slate-500 dark:text-slate-400 mt-3 font-medium text-lg">Create a professional video ad
                    with full customization</p>
            </div>

            <!-- Form -->
            <form id="uploadForm" method="POST" action="{{ route('videos.store') }}" enctype="multipart/form-data"
                class="space-y-10">
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">

                    <!-- Left Column: Media -->
                    <div class="space-y-8">
                        <!-- Video Input -->
                        <div class="space-y-3">
                            <label class="text-sm font-bold text-slate-700 dark:text-slate-300 ml-1">Video File</label>
                            <label
                                class="group relative flex flex-col items-center justify-center w-full h-56 border-2 border-dashed border-slate-300 dark:border-slate-700 rounded-[2rem] cursor-pointer bg-slate-50/50 dark:bg-slate-800/50 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all">
                                <div class="flex flex-col items-center justify-center p-6 text-center">
                                    <div
                                        class="w-16 h-16 bg-slate-200 dark:bg-slate-700 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                                        <svg class="w-8 h-8 text-slate-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path
                                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"
                                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                        </svg>
                                    </div>
                                    <p class="text-sm font-bold text-slate-700 dark:text-slate-300">Drop your video here
                                    </p>
                                    <p class="text-xs text-slate-400 mt-1">MP4, MKV or AVI (Max 200MB)</p>
                                </div>
                                <input type="file" id="videoInput" name="video" class="hidden" accept="video/*"
                                    required />
                                <div id="videoNameDisplay"
                                    class="absolute bottom-4 text-xs font-bold text-blue-600 bg-blue-50 px-3 py-1 rounded-full hidden">
                                </div>
                            </label>
                        </div>

                        <!-- Thumbnail Input -->
                        <div class="space-y-3">
                            <label class="text-sm font-bold text-slate-700 dark:text-slate-300 ml-1">Custom Thumbnail
                                (Poster)</label>
                            <div class="flex items-center gap-4">
                                <div id="thumbPreview"
                                    class="w-24 h-24 rounded-2xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center overflow-hidden border border-slate-200 dark:border-slate-700">
                                    <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <label
                                    class="flex-1 cursor-pointer bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 px-6 py-4 rounded-2xl text-sm font-bold text-slate-600 dark:text-slate-400 hover:bg-slate-50 transition-all text-center">
                                    <span>Pick Thumbnail</span>
                                    <input type="file" id="thumbInput" name="thumbnail" class="hidden"
                                        accept="image/*" />
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Details -->
                    <div class="space-y-8">
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-700 dark:text-slate-300 ml-1">Campaign
                                Title</label>
                            <input type="text" name="title" required placeholder="e.g. Summer Special Offer"
                                class="w-full rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/50 px-6 py-4 text-sm font-medium focus:ring-2 focus:ring-slate-900/5 focus:border-slate-900 dark:focus:border-white transition-all outline-none">
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-700 dark:text-slate-300 ml-1">Category</label>
                            <select name="category"
                                class="w-full rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/50 px-6 py-4 text-sm font-medium focus:ring-2 focus:ring-slate-900/5 focus:border-slate-900 dark:focus:border-white transition-all outline-none appearance-none">
                                <option value="General">General</option>
                                <option value="Food & Drink">Food & Drink</option>
                                <option value="Fashion">Fashion</option>
                                <option value="Electronics">Electronics</option>
                                <option value="Real Estate">Real Estate</option>
                                <option value="Services">Services</option>
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-700 dark:text-slate-300 ml-1">Description</label>
                            <textarea name="description" rows="5" placeholder="Add some context for your viewers..."
                                class="w-full rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/50 px-6 py-4 text-sm font-medium focus:ring-2 focus:ring-slate-900/5 focus:border-slate-900 dark:focus:border-white transition-all outline-none resize-none"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Preview Box -->
                <div id="previewContainer" class="hidden animate-in fade-in slide-in-from-bottom-4 duration-500">
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 ml-1 mb-3">Live
                        Preview</label>
                    <div
                        class="relative rounded-3xl overflow-hidden bg-black aspect-video shadow-2xl ring-8 ring-slate-100 dark:ring-slate-800">
                        <video id="videoPreview" class="w-full h-full" controls></video>
                    </div>
                </div>

                <!-- Progress Section -->
                <div id="progressContainer" class="hidden space-y-4">
                    <div class="flex justify-between items-end">
                        <div>
                            <span id="progressStatus"
                                class="text-lg font-bold text-slate-900 dark:text-white block">Starting
                                Upload...</span>
                            <span class="text-xs text-slate-400 font-medium">Please don't close this window</span>
                        </div>
                        <span id="progressPercent"
                            class="text-3xl font-black text-slate-900 dark:text-white">0%</span>
                    </div>
                    <div
                        class="w-full bg-slate-100 dark:bg-slate-800 rounded-full h-4 overflow-hidden border border-slate-200/50 dark:border-slate-700/50">
                        <div id="progressBar"
                            class="progress-bar w-0 h-full bg-slate-900 dark:bg-white rounded-full shadow-lg"></div>
                    </div>
                </div>

                <!-- Footer Actions -->
                <div class="pt-10 border-t border-slate-100 dark:border-slate-800 flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex-1 px-8 py-5 rounded-[1.5rem] text-sm font-bold text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all text-center">Discard</a>
                    <button type="submit" id="submitBtn"
                        class="flex-[2] bg-slate-900 dark:bg-white text-white dark:text-slate-900 py-5 rounded-[1.5rem] text-sm font-black tracking-widest uppercase hover:scale-[1.02] active:scale-95 transition-all shadow-2xl shadow-slate-900/20">Launch
                        Campaign</button>
                </div>

            </form>

        </section>

    </main>

    <script>
        const uploadForm = document.getElementById('uploadForm');
        const videoInput = document.getElementById('videoInput');
        const thumbInput = document.getElementById('thumbInput');
        const videoPreview = document.getElementById('videoPreview');
        const thumbPreview = document.getElementById('thumbPreview');
        const previewContainer = document.getElementById('previewContainer');
        const progressContainer = document.getElementById('progressContainer');
        const progressBar = document.getElementById('progressBar');
        const progressPercent = document.getElementById('progressPercent');
        const progressStatus = document.getElementById('progressStatus');
        const submitBtn = document.getElementById('submitBtn');
        const videoNameDisplay = document.getElementById('videoNameDisplay');

        // Video selection
        videoInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const url = URL.createObjectURL(file);
                videoPreview.src = url;
                previewContainer.classList.remove('hidden');
                videoNameDisplay.innerText = file.name;
                videoNameDisplay.classList.remove('hidden');
            } else {
                previewContainer.classList.add('hidden');
                videoNameDisplay.classList.add('hidden');
            }
        });

        // Thumbnail selection
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

        // Form Submit with Progress
        uploadForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(uploadForm);
            const xhr = new XMLHttpRequest();

            xhr.upload.addEventListener('progress', (e) => {
                if (e.lengthComputable) {
                    const percent = Math.round((e.loaded / e.total) * 100);
                    progressBar.style.width = percent + '%';
                    progressPercent.innerText = percent + '%';
                    if (percent < 30) progressStatus.innerText = 'Uploading Media...';
                    else if (percent < 80) progressStatus.innerText = 'Optimizing for Web...';
                    else if (percent < 100) progressStatus.innerText = 'Finalizing...';
                    else progressStatus.innerText = 'Saving to Database...';
                }
            });

            progressContainer.classList.remove('hidden');
            submitBtn.disabled = true;
            submitBtn.innerText = 'Processing...';

            xhr.onload = function() {
                if (xhr.status === 200 || xhr.responseURL.includes('overview') || xhr.responseURL.includes(
                        'overview')) {
                    progressStatus.innerText = 'Campaign Live!';
                    setTimeout(() => window.location.href = "{{ route('admin.dashboard') }}", 1000);
                } else {
                    alert('Error: ' + xhr.responseText);
                    submitBtn.disabled = false;
                }
            };

            xhr.open('POST', uploadForm.action, true);
            xhr.send(formData);
        });
    </script>

</body>

</html>
