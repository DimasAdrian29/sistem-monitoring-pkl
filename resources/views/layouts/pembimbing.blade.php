<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>@yield('title', 'Pembimbing Dashboard')</title>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: { "primary": "#0d6dfd" },
                    fontFamily: { "display": ["Lexend", "sans-serif"] }
                },
            },
        }
    </script>
    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        body { font-family: 'Lexend', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 dark:bg-gray-900 min-h-screen text-slate-900 dark:text-white">
    <div class="mx-auto max-w-5xl min-h-screen flex flex-col bg-white dark:bg-gray-800 shadow-xl">

        {{-- 1. HEADER (Bisa disembunyikan jika perlu) --}}
        @if(!isset($hideHeader) || !$hideHeader)
            @include('pembimbing.partials.header')
        @endif

        {{-- 2. ISI KONTEN (pb-32 hanya muncul jika navbar ada) --}}
        <main class="flex-1 overflow-y-auto no-scrollbar {{ !isset($hideNav) || !$hideNav ? 'pb-32' : '' }}">
            @yield('content')
        </main>

        {{-- 3. BOTTOM NAVBAR (Bisa disembunyikan jika perlu) --}}
        @if(!isset($hideNav) || !$hideNav)
            @include('pembimbing.partials.bottom-nav')
        @endif

    </div>

    <script>
        // Dropdown Profile Logic
        function toggleDropdown() {
            const menu = document.getElementById('profileDropdown');
            if(menu) menu.classList.toggle('hidden');
        }

        window.onclick = function(event) {
            if (!event.target.closest('#profileButton')) {
                const dropdown = document.getElementById('profileDropdown');
                if (dropdown && !dropdown.classList.contains('hidden')) {
                    dropdown.classList.add('hidden');
                }
            }
        }
    </script>
</body>
</html>
