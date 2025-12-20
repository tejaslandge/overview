<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <!-- REQUIRED for mobile -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Upload Video</title>
    <link rel="shortcut icon" href="{{ asset('assets/logo_icon.png') }}" type="image/png">

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-100 min-h-screen text-slate-800">

    <main class="min-h-screen flex items-center justify-center px-4">

        <section class="w-full max-w-lg bg-white rounded-xl border shadow-sm p-6 sm:p-8">

            <!-- Header -->
            <div class="mb-6 text-center">
                <h1 class="text-2xl font-semibold">
                    Upload Video
                </h1>
                <p class="text-sm text-slate-500 mt-1">
                    Add a new video to your library
                </p>
            </div>

            <!-- Form -->
            <form method="POST" action="/upload" enctype="multipart/form-data" class="space-y-5">
                @csrf

                <!-- Video Input -->
                <div>
                    <label class="block text-sm font-medium mb-1">
                        Video File
                    </label>
                    <input type="file" name="video" accept="video/*" required
                        class="block w-full text-sm text-slate-600
                               file:mr-4 file:py-2.5 file:px-4
                               file:rounded-lg file:border-0
                               file:bg-slate-800 file:text-white
                               hover:file:bg-slate-900 transition">
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-medium mb-1">
                        Description
                    </label>
                    <textarea name="description" rows="4" placeholder="Brief description of the video..."
                        class="w-full rounded-lg border border-slate-300
                               px-3 py-2 text-sm
                               focus:border-slate-500 focus:ring-slate-500"></textarea>
                </div>

                <!-- Actions -->
                <div class="pt-2">
                    <button type="submit"
                        class="w-full bg-slate-800 text-white
                               py-2.5 rounded-lg text-sm font-medium
                               hover:bg-slate-900 transition">
                        Upload Video
                    </button>
                </div>

            </form>

        </section>

    </main>

</body>

</html>
