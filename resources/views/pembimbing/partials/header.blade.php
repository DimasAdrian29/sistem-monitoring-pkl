<header class="sticky top-0 z-50 flex items-center bg-white/80 dark:bg-gray-800/80 backdrop-blur-md px-4 py-4 border-b border-slate-100 dark:border-gray-700 justify-between">
    <div class="flex items-center gap-3">
        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-white dark:bg-gray-700 shadow-sm border border-slate-100 dark:border-gray-600 overflow-hidden">
            <img src="{{ asset('images/logo_sekolah.png') }}"
                 alt="Logo SMKN 5 Pekanbaru"
                 class="h-9 w-9 object-contain">
        </div>

        <div>
            <h2 class="text-base font-bold leading-tight text-slate-900 dark:text-white">SMKN 5 Pekanbaru</h2>
            <p class="text-slate-500 dark:text-slate-400 text-[10px] uppercase tracking-wider font-semibold">Sistem Informasi Magang</p>
        </div>
    </div>

    <div class="relative">
        <button id="profileButton" onclick="toggleDropdown()" class="flex h-10 w-10 items-center justify-center rounded-full bg-slate-100 dark:bg-gray-700 hover:bg-slate-200 transition-colors focus:outline-none">
            <span class="material-symbols-outlined text-slate-700 dark:text-slate-200">person</span>
        </button>

        <div id="profileDropdown" class="hidden absolute right-0 mt-2 w-48 rounded-2xl bg-white dark:bg-gray-700 shadow-xl border border-slate-100 dark:border-gray-600 py-2 z-[60]">
            <a href="#" class="flex items-center gap-2 px-4 py-2 text-sm hover:bg-slate-50 dark:hover:bg-gray-600">
                <span class="material-symbols-outlined text-sm">account_circle</span> Profil Saya
            </a>
            <hr class="my-1 border-slate-100 dark:border-gray-600">
            <form method="POST" action="/logout">
                @csrf
                <button type="submit" class="w-full flex items-center gap-2 px-4 py-2 text-sm text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20">
                    <span class="material-symbols-outlined text-sm">logout</span> Logout
                </button>
            </form>
        </div>
    </div>
</header>
