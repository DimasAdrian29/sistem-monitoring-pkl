<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ForumChat;
use App\Models\PraktekKerjaLapangan;
use App\Models\Siswa;
use App\Models\GuruPembimbing;
use App\Models\PembimbingIndustri;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ChatForum extends Component
{
    public $isi_pesan;
    public $industri_id;

    public function mount()
    {
        $user = Auth::user();

        // LOGIKA DETEKSI INDUSTRI YANG LEBIH AMAN
        if ($user->role === 'siswa') {
            $siswa = Siswa::where('user_id', $user->id)->first();
            $pkl = PraktekKerjaLapangan::where('siswa_id', $siswa->id)->first();
            $this->industri_id = $pkl ? $pkl->industri_id : null;

        } elseif ($user->role === 'pembimbing_industri') {
            $pembimbing = PembimbingIndustri::where('user_id', $user->id)->first();
            $this->industri_id = $pembimbing ? $pembimbing->industri_id : null;

        } elseif ($user->role === 'guru_pembimbing') {
            $guru = GuruPembimbing::where('user_id', $user->id)->first();
            // Ambil salah satu siswa bimbingannya untuk mengetahui industrinya
            $pkl = PraktekKerjaLapangan::where('guru_pembimbing_id', $guru->id)->first();
            $this->industri_id = $pkl ? $pkl->industri_id : null;
        }
    }

    public function sendMessage()
    {
        $this->validate(['isi_pesan' => 'required']);

        ForumChat::create([
            'industri_id' => $this->industri_id,
            'user_id' => Auth::id(),
            'isi_pesan' => $this->isi_pesan,
        ]);

        $this->isi_pesan = '';
        $this->dispatch('scroll-bottom');
    }

    public function render()
    {
        $user = Auth::user();

        $chats = ForumChat::with('user')
            ->where('industri_id', $this->industri_id)
            ->orderBy('created_at', 'asc')
            ->get();

        $chats->transform(function ($chat) use ($user) {
            $chat->is_me = $chat->user_id === $user->id;
            $chat->time = $chat->created_at->timezone('Asia/Jakarta')->format('H:i');

            $sender = match ($chat->user->role) {
                'siswa' => Siswa::where('user_id', $chat->user_id)->first(),
                'guru_pembimbing' => GuruPembimbing::where('user_id', $chat->user_id)->first(),
                'pembimbing_industri' => PembimbingIndustri::where('user_id', $chat->user_id)->first(),
                default => null
            };

            $chat->sender_name = $sender ? $sender->nama : 'User';
            $chat->role_label = str_replace('_', ' ', ucwords($chat->user->role, '_'));

            return $chat;
        });

        $groupedChats = $chats->groupBy(fn($c) => Carbon::parse($c->created_at)->timezone('Asia/Jakarta')->translatedFormat('d F Y'));

        return view('livewire.chat-forum', [
            'groupedChats' => $groupedChats
        ]);
    }
}
