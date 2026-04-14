<?php

namespace App\Filament\Widgets;

use App\Models\Absensi;
use Filament\Widgets\ChartWidget;

class KehadiranChart extends ChartWidget
{
    protected static ?string $heading = 'Akumulasi Status Kehadiran Siswa PKL';

    protected static ?int $sort = 2;
// Tambahkan/ubah baris ini:
    protected int | string | array $columnSpan = 'full';
    protected function getData(): array
    {
        $hadir = Absensi::where('status_kehadiran', 'Hadir')->count();
        $izin = Absensi::where('status_kehadiran', 'Izin')->count();
        $sakit = Absensi::where('status_kehadiran', 'Sakit')->count();
        $alpa = Absensi::where('status_kehadiran', 'Alpa')->count();

        return [
            'datasets' => [
                [
                    'label' => 'Total Record Absensi',
                    'data' => [$hadir, $izin, $sakit, $alpa],
                    'backgroundColor' => [
                        'rgba(16, 185, 129, 0.8)', // Emerald / Hijau (Hadir)
                        'rgba(245, 158, 11, 0.8)', // Amber / Kuning (Izin)
                        'rgba(59, 130, 246, 0.8)', // Blue / Biru (Sakit)
                        'rgba(239, 68, 68, 0.8)',  // Red / Merah (Alpa)
                    ],
                    'borderColor' => [
                        '#10b981',
                        '#f59e0b',
                        '#3b82f6',
                        '#ef4444',
                    ],
                    'borderWidth' => 1,
                    // Membuat ujung bar sedikit melengkung agar lebih modern
                    'borderRadius' => 4,
                ],
            ],
            'labels' => ['Hadir', 'Izin', 'Sakit', 'Alpa'],
        ];
    }

    protected function getType(): string
    {
        // Ganti doughnut menjadi bar chart
        return 'bar';
    }

    // --- TAMBAHAN OPSIONAL AGAR CHART TIDAK TERLALU TINGGI ---
    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                ],
            ],
        ];
    }
}
