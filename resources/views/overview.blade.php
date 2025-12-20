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
                            <video class="w-full max-h-[520px] object-contain" controls preload="metadata">
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


        <!-- Company Information -->
        <section class="mt-16 space-y-12">

            <!-- About Us -->
            <div
                class="bg-white rounded-xl border shadow-sm p-6 sm:p-8
               transform transition duration-500 ease-out
               hover:-translate-y-1 hover:shadow-md
               animate-fade-in-up">
                <h2 class="text-xl sm:text-2xl font-semibold mb-4 flex items-center gap-2">
                    🏢 About Us
                </h2>
                <p class="text-slate-700 leading-relaxed max-w-4xl">
                    Shops Digital Ads is a retail-focused digital advertising platform founded in 2022,
                    built on extensive on-ground market experience and a deep understanding of customer
                    behavior within retail environments. With increasing demand, demonstrated success,
                    and a long-term vision, the business was formally structured in September 2025 under
                    Brando Digitech Pvt. Ltd. to support large-scale expansion and professional operations.
                </p>
                <p class="text-slate-700 leading-relaxed max-w-4xl mt-4">
                    Our platform connects brands directly with customers at the point where buying
                    decisions are made inside local retail stores creating meaningful visibility
                    that drives real recall and word-of-mouth impact.
                </p>
            </div>

            <!-- Vision & Mission -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                <!-- Vision -->
                <div
                    class="bg-white rounded-xl border shadow-sm p-6 sm:p-8
                   transform transition duration-500 ease-out
                   hover:-translate-y-1 hover:shadow-md
                   animate-fade-in-up delay-100">
                    <h3 class="text-lg sm:text-xl font-semibold mb-3 flex items-center gap-2">
                        👁️ Our Vision
                    </h3>
                    <p class="text-slate-700 leading-relaxed">
                        To build India’s most trusted retail digital advertising network connecting
                        brands, retailers, and customers through meaningful, high-visibility advertising
                        at the point of purchase.
                    </p>
                </div>

                <!-- Mission -->
                <div
                    class="bg-white rounded-xl border shadow-sm p-6 sm:p-8
                   transform transition duration-500 ease-out
                   hover:-translate-y-1 hover:shadow-md
                   animate-fade-in-up delay-200">
                    <h3 class="text-lg sm:text-xl font-semibold mb-3 flex items-center gap-2">
                        🎯 Our Mission
                    </h3>
                    <ul class="list-disc list-inside text-slate-700 space-y-2 leading-relaxed">
                        <li>Help brands grow locally before scaling nationally.</li>
                        <li>Enable retailers to earn additional income through in-store digital screens.</li>
                        <li>Provide cost-effective advertising with measurable, real-world impact.</li>
                        <li>Strengthen brand recall at moments when purchasing decisions are made.</li>
                    </ul>
                </div>

            </div>

        </section>


    </main>

</body>

</html>
