<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Shops Digital Ads</title>

    <meta http-equiv="Content-Security-Policy" content="script-src 'self' https://cdn.tailwindcss.com;">

    <link rel="shortcut icon" href="{{ asset('assets/logo_icon.png') }}" type="image/png">

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-100 min-h-screen text-slate-800">

    <!-- Header -->
    <header class="bg-white border-b">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-4 flex items-center">
            <img src="{{ asset('assets/logo.png') }}" alt="Company Logo" class="h-9">
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-6xl mx-auto px-4 sm:px-6 py-8">

        <!-- Page Intro -->
        <div class="mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold mb-2">
                Digital Advertising Samples
            </h1>
            <p class="text-slate-600 max-w-3xl">
                Below are selected video advertisements created for retail and local business campaigns.
                These samples demonstrate our approach to visual storytelling and performance-focused creatives.
            </p>
        </div>

        @if ($videos->count())

            <!-- Video List -->
            <div class="space-y-10">

                @foreach ($videos as $video)
                    <div class="bg-white rounded-xl shadow-sm border overflow-hidden">

                        <!-- Video -->
                        <div class="bg-black">
                            <video
                                class="w-full max-h-[520px] object-contain"
                                controls
                                preload="metadata"
                            >
                                <source src="{{ asset($video->file_path) }}">
                                Your browser does not support the video tag.
                            </video>
                        </div>

                        <!-- Description -->
                        @if ($video->description)
                            <div class="p-5 border-t">
                                <p class="text-sm sm:text-base text-slate-700 leading-relaxed">
                                    {{ $video->description }}
                                </p>
                            </div>
                        @endif

                    </div>
                @endforeach

            </div>

        @else
            <!-- Empty State -->
            <div class="bg-white rounded-xl shadow-sm p-12 text-center">
                <h3 class="text-lg font-semibold mb-2">
                    No Videos Available
                </h3>
                <p class="text-slate-500">
                    Advertising samples will be displayed here once uploaded.
                </p>
            </div>
        @endif

    </main>

</body>
</html>
