<header class="sticky top-0 z-50 bg-white/80 dark:bg-gray-800/80 backdrop-blur-md px-4 h-16 flex items-center border-b border-slate-100 dark:border-gray-700">
    <a href="{{ $backUrl ?? '#' }}" class="p-2 -ml-2 rounded-full hover:bg-slate-100 dark:hover:bg-gray-700 transition-colors text-slate-800 dark:text-white flex items-center justify-center">
        <span class="material-symbols-outlined text-[24px]">arrow_back_ios_new</span>
    </a>

    <h1 class="text-lg font-bold text-slate-800 dark:text-white flex-1 text-center pr-10">
        {{ $title ?? 'Menu' }}
    </h1>
</header>
