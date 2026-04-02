<?php
namespace App\Http\Controllers;

class ForumController extends Controller
{
    // Fungsi untuk membuka halaman forum dari sisi Siswa
    public function indexSiswa()
    {
        return view('siswa.forum_diskusi');
    }

    // Fungsi untuk membuka halaman forum dari sisi Pembimbing Industri
    public function indexPembimbing()
    {
        return view('pembimbing.forum_diskusi');
    }
}
