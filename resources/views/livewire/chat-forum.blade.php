<div class="flex flex-col h-full relative">

    <div id="chatContainer" wire:poll.3s class="flex-1 overflow-y-auto p-4 space-y-6 no-scrollbar pb-32">
        @foreach ($groupedChats as $date => $chats)
            <div class="flex justify-center my-4">
                <span class="text-[10px] font-bold text-slate-400 bg-slate-200/50 px-3 py-1 rounded-full uppercase">{{ $date }}</span>
            </div>

            @foreach ($chats as $chat)
                @if ($chat->is_me)
                    <div class="flex flex-col items-end gap-1 ml-auto max-w-[85%]">
                        {{-- PERBAIKAN DI SINI: Ditulis dalam 1 baris tanpa enter --}}
                        <div class="bg-primary text-white px-4 py-3 rounded-2xl rounded-br-none shadow-md text-sm whitespace-pre-wrap break-words">{{ $chat->isi_pesan }}</div>
                        <span class="text-[9px] text-slate-400 mr-1">{{ $chat->time }}</span>
                    </div>
                @else
                    <div class="flex items-end gap-3 max-w-[85%]">
                        <div class="flex flex-col gap-1">
                            <span class="text-[10px] font-bold text-primary ml-1 uppercase tracking-tighter">{{ $chat->role_label }} - {{ $chat->sender_name }}</span>
                            {{-- PERBAIKAN DI SINI: Ditulis dalam 1 baris tanpa enter --}}
                            <div class="bg-white dark:bg-gray-800 px-4 py-3 rounded-2xl rounded-bl-none shadow-sm border border-slate-100 text-sm whitespace-pre-wrap break-words">{{ $chat->isi_pesan }}</div>
                            <span class="text-[9px] text-slate-400 ml-1">{{ $chat->time }}</span>
                        </div>
                    </div>
                @endif
            @endforeach
        @endforeach
    </div>

    <div class="fixed bottom-0 left-0 right-0 z-50 p-4 bg-white dark:bg-gray-800 border-t border-slate-100 dark:border-gray-700 shadow-[0_-10px_40px_rgba(0,0,0,0.05)]">
        <div class="max-w-2xl mx-auto">
            <form wire:submit.prevent="sendMessage" class="flex items-end gap-2">
                <textarea wire:model="isi_pesan" rows="1" required
                          class="flex-1 bg-slate-50 dark:bg-gray-700 border-transparent focus:border-primary/30 focus:ring-4 focus:ring-primary/10 rounded-2xl px-4 py-3 text-sm dark:text-white resize-none no-scrollbar"
                          placeholder="Ketik pesan..."></textarea>
                <button type="submit" class="h-11 w-11 shrink-0 rounded-2xl bg-primary text-white flex items-center justify-center shadow-lg shadow-primary/20 hover:bg-blue-600 active:scale-95 transition-all">
                    <span class="material-symbols-outlined text-xl ml-0.5">send</span>
                </button>
            </form>
        </div>
    </div>

    <script>
        window.addEventListener('scroll-bottom', () => {
            var container = document.getElementById("chatContainer");
            container.scrollTop = container.scrollHeight;
        });
    </script>
</div>
