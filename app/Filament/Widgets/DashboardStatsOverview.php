<?php

namespace App\Filament\Widgets;

use App\Models\Industri;
use App\Models\Siswa;
use App\Models\GuruPembimbing;
use App\Models\PembimbingIndustri;
use App\Models\PengajuanMagang;
use App\Models\PraktekKerjaLapangan;
use App\Models\Logbook;
use App\Models\Absensi;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Carbon\Carbon;

class DashboardStatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $hariIni = Carbon::today();

        return [
            // 1. Total Siswa
            Stat::make('Total Siswa', Siswa::count())
                ->description('Total siswa terdaftar')
                ->descriptionIcon('heroicon-m-users')
                ->chart([5, 10, 15, 25, 40, Siswa::count()]) // Sparkline naik
                ->color('primary'),

            // 2. Guru Pembimbing
            Stat::make('Guru Pembimbing', GuruPembimbing::count())
                ->description('Jumlah guru aktif')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->chart([2, 4, 4, 6, 8, GuruPembimbing::count()]) // Sparkline
                ->color('success'),

            // 3. Mitra Industri
            Stat::make('Mitra Industri', Industri::count())
                ->description('Perusahaan bekerja sama')
                ->descriptionIcon('heroicon-m-building-office-2')
                ->chart([1, 3, 5, 5, 7, Industri::count()]) // Sparkline
                ->color('info'),

            // 4. Pembimbing Industri
            Stat::make('Pembimbing Industri', PembimbingIndustri::count())
                ->description('Pembimbing di lapangan')
                ->descriptionIcon('heroicon-m-user-group')
                ->chart([2, 3, 5, 8, 10, PembimbingIndustri::count()]) // Sparkline
                ->color('warning'),

            // 5. Total Pengajuan
            Stat::make('Total Pengajuan', PengajuanMagang::count())
                ->description('Riwayat pengajuan magang')
                ->descriptionIcon('heroicon-m-document-text')
                ->chart([5, 12, 8, 15, 20, 18]) // Efek fluktuasi
                ->color('gray'),

            // 6. PKL Aktif
            Stat::make('PKL Aktif', PraktekKerjaLapangan::where('status_magang', 'Aktif')->count())
                ->description('Siswa yang sedang berjalan')
                ->descriptionIcon('heroicon-m-briefcase')
                ->chart([7, 10, 13, 15, 14, 17, 20]) // Efek naik
                ->color('success'),

            // 7. Logbook Menunggu
            Stat::make('Logbook Menunggu Validasi', Logbook::where('status_validasi', 'Menunggu')->count())
                ->description('Butuh tindakan pembimbing')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->chart([10, 5, 2, 8, 12]) // Fluktuasi
                ->color('danger'),

            // 8. Absensi Hari Ini
            Stat::make('Hadir Hari Ini', Absensi::whereDate('tanggal', $hariIni)->where('status_kehadiran', 'Hadir')->count())
                ->description('Dari total absen masuk hari ini')
                ->descriptionIcon('heroicon-m-check-badge')
                ->chart([0, 10, 25, 40, 55, 70]) // Simulasi absen masuk dari pagi
                ->color('primary'),
        ];
    }

    // --- TAMBAHKAN INI AGAR TAMPILAN RAPI 4 KOLOM ---
    protected function getColumns(): int
    {
        return 4; // 8 kartu akan terbagi rata menjadi 2 baris (4 kartu per baris)
    }
}
