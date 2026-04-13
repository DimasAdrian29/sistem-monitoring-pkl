<nav
    class="sticky bottom-0 w-full border-t border-slate-200 dark:border-gray-700 bg-white dark:bg-gray-800 pb-6 pt-3 z-40">
    <div class="flex justify-around items-end">

        <a class="flex flex-1 flex-col items-center justify-center gap-1 {{ request()->is('siswa') ? 'text-primary' : 'text-slate-400 dark:text-slate-500 hover:text-primary' }} transition-colors"
            href="{{ url('/siswa') }}">
            <span class="material-symbols-outlined text-[26px]"
                style="{{ request()->is('siswa') ? "font-variation-settings: 'FILL' 1;" : '' }}">home</span>
            <span class="text-[10px] font-medium leading-none">Home</span>
        </a>

        <a class="flex flex-1 flex-col items-center justify-center gap-1 {{ request()->is('aktivitas*') ? 'text-primary' : 'text-slate-400 dark:text-slate-500 hover:text-primary' }} transition-colors"
            href="{{ route('aktivitas.index') }}">
            <span class="material-symbols-outlined text-[26px]"
                style="{{ request()->is('aktivitas*') ? "font-variation-settings: 'FILL' 1;" : '' }}">list_alt</span>
            <span class="text-[10px] font-medium leading-none">Activity</span>
        </a>

        <a class="flex flex-1 flex-col items-center justify-center gap-1 {{ request()->is('profile*') ? 'text-primary' : 'text-slate-400 dark:text-slate-500 hover:text-primary' }} transition-colors"
            href="{{ route('profile.index') }}">
            <span class="material-symbols-outlined text-[26px]"
                style="{{ request()->is('profile*') ? "font-variation-settings: 'FILL' 1;" : '' }}">person</span>
            <span class="text-[10px] font-medium leading-none">Profil</span>
        </a>

    </div>
</nav>
