<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Times New Roman', serif;
            width: 297mm;
        }

        /* ===================== */
        /* HALAMAN DEPAN         */
        /* ===================== */
        .halaman-depan {
            width: 290mm;
            height: 195mm;

            border: 8px solid #c8a84b;
            outline: 3px solid #c8a84b;
            outline-offset: -12px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            background: #fffdf5;
            page-break-after: always;
        }

        .halaman-depan .judul {
            font-size: 36pt;
            font-weight: bold;
            color: #c8a84b;
            letter-spacing: 4px;
            text-transform: uppercase;
            margin-bottom: 4px;
        }

        .halaman-depan .sub-judul {
            font-size: 14pt;
            color: #8B6914;
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-bottom: 30px;
            border-bottom: 2px solid #c8a84b;
            padding-bottom: 12px;
        }

        .halaman-depan .label-kepada {
            font-size: 11pt;
            color: #555;
            margin-bottom: 6px;
        }

        .halaman-depan .nama-siswa {
            font-size: 28pt;
            font-weight: bold;
            color: #1a4a8a;
            text-transform: uppercase;
            letter-spacing: 2px;
            text-decoration: underline;
            margin-bottom: 20px;
        }

        .halaman-depan .info-siswa {
            font-size: 11pt;
            color: #333;
            line-height: 1.9;
            margin-bottom: 10px;
        }

        .halaman-depan .nama-industri {
            font-size: 18pt;
            font-weight: bold;
            color: #c0392b;
            margin: 4px 0 8px;
        }

        .halaman-depan .periode {
            font-size: 11pt;
            color: #333;
            margin-bottom: 4px;
        }

        .halaman-depan .catatan-nilai {
            font-size: 10pt;
            color: #555;
            margin-bottom: 30px;
        }

        .ttd-area {
            width: 100%;
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
        }

        .ttd-box {
            text-align: center;
            width: 200px;
        }

        .ttd-box .kota-tanggal {
            font-size: 10pt;
            color: #333;
            margin-bottom: 4px;
        }

        .ttd-box .nama-penandatangan {
            font-size: 10pt;
            font-weight: bold;
            border-top: 1px solid #333;
            padding-top: 4px;
            margin-top: 60px; /* space untuk tanda tangan */
        }

        .ttd-box .jabatan {
            font-size: 9pt;
            color: #555;
        }

        /* Logo area bawah kiri */
        .logo-area {
            position: absolute;
            bottom: 15mm;
            left: 20mm;
            display: flex;
            gap: 10px;
            align-items: center;
        }

        /* ===================== */
        /* HALAMAN BELAKANG      */
        /* ===================== */
        .halaman-belakang {
            width: 290mm;
            height: 200mm;
            padding: 3mm 3mm;
            background: #fffdf5;
            page-break-after: avoid;
        }

        .belakang-judul {
            text-align: center;
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 10px;
            color: #1a1a1a;
        }

        .info-siswa-belakang {
            font-size: 10pt;
            margin-bottom: 12px;
            color: #333;
        }

        .info-siswa-belakang table {
            border-collapse: collapse;
        }

        .info-siswa-belakang td {
            padding: 2px 6px;
            font-size: 10pt;
        }

        .tabel-nilai {
            width: 100%;
            border-collapse: collapse;
            font-size: 10pt;
            margin-bottom: 10px;
        }

        .tabel-nilai th {
            background-color: #2c5f9e;
            color: white;
            padding: 6px 8px;
            text-align: center;
            font-size: 9.5pt;
        }

        .tabel-nilai td {
            border: 1px solid #ccc;
            padding: 5px 8px;
            font-size: 10pt;
        }

        .tabel-nilai .jumlah-row td {
            font-weight: bold;
            background-color: #f0f0f0;
        }

        .tabel-nilai .rata-row td {
            font-weight: bold;
            background-color: #e8f0fe;
        }

        .tabel-wrapper {
            display: flex;
            gap: 12mm;
        }

        .tabel-wrapper > div {
            flex: 1;
        }

        .tabel-section-title {
            font-size: 10pt;
            font-weight: bold;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .predikat-table {
            border-collapse: collapse;
            font-size: 9pt;
            margin-top: 6px;
        }

        .predikat-table th, .predikat-table td {
            border: 1px solid #ccc;
            padding: 3px 8px;
            text-align: center;
        }

        .predikat-table th {
            background-color: #e0e0e0;
            font-weight: bold;
        }

        .ttd-belakang {
            display: flex;
            justify-content: flex-end;
            margin-top: 12px;
        }
    </style>
</head>
<body>

{{-- ==================== --}}
{{-- HALAMAN DEPAN        --}}
{{-- ==================== --}}
<div class="halaman-depan">
    <div class="judul">Sertifikat</div>
    <div class="sub-judul">Praktik Kerja Lapangan</div>

    <div class="label-kepada">Diberikan Kepada :</div>
    <div class="nama-siswa">{{ strtoupper($pkl->siswa->nama) }}</div>

    <div class="info-siswa">
        Siswa SMK Negeri 5 Pekanbaru<br>
        Kompetensi Keahlian {{ $pkl->siswa->jurusan }}<br>
        Telah Melaksanakan Praktik Kerja Lapangan (PKL) Di
    </div>

    <div class="nama-industri">{{ strtoupper($pkl->industri->nama) }}</div>

    <div class="periode">
        Periode {{ \Carbon\Carbon::parse($pkl->tgl_mulai)->isoFormat('MMMM') }} - {{ \Carbon\Carbon::parse($pkl->tgl_selesai)->isoFormat('MMMM Y') }}
    </div>
    <div class="catatan-nilai">Dengan Nilai Tercantum Di Belakang Sertifikat Ini.</div>

    <div class="ttd-area">
        <div class="ttd-box">
            <div class="kota-tanggal">Pekanbaru, {{ \Carbon\Carbon::parse($pkl->tgl_selesai)->isoFormat('D MMMM Y') }}</div>
            <div class="kota-tanggal">{{ $pkl->industri->nama }}</div>
            {{-- Tanda tangan dikosongkan --}}
            <div class="nama-penandatangan">{{ $pkl->pembimbingIndustri->nama }}</div>
            <div class="jabatan">{{ $pkl->pembimbingIndustri->jabatan }}</div>
        </div>
    </div>
</div>

{{-- ==================== --}}
{{-- HALAMAN BELAKANG     --}}
{{-- ==================== --}}
<div class="halaman-belakang">
    <div class="belakang-judul">Daftar Nilai Praktik Kerja Lapangan (PKL)</div>

    <div class="info-siswa-belakang">
        <table>
            <tr><td>Nama</td><td>: {{ $pkl->siswa->nama }}</td><td style="padding-left:20px">Tempat PKL</td><td>: {{ $pkl->industri->nama }}</td></tr>
            <tr><td>Nomor Induk Siswa</td><td>: {{ $pkl->siswa->nisn }}</td><td style="padding-left:20px">Kompetensi Keahlian</td><td>: {{ $pkl->siswa->jurusan }}</td></tr>
        </table>
    </div>

    @php
        $nilai = $pkl->nilai;

        // Aspek penilaian (sesuaikan label dengan kebutuhan sekolahmu)
        $aspekIndustri = [
            'Soft Skills Dunia Kerja'    => $nilai->aspek_soft_skills ?? 0,
            'Norma, POS & K3LH'          => $nilai->aspek_norma_k3lh ?? 0,
            'Kompetensi Teknis'          => $nilai->aspek_kompetensi_teknis ?? 0,
            'Wawasan Bisnis & Wirausaha' => $nilai->aspek_wawasan_bisnis ?? 0,
        ];

        $aspekSekolah = [
            'Penyusunan Laporan PKL'   => $nilai->aspek_penyusunan_laporan ?? 0,
            'Presentasi Hasil PKL'     => $nilai->aspek_presentasi ?? 0,
        ];

        $totalIndustri = array_sum($aspekIndustri);
        $rataIndustri  = count($aspekIndustri) > 0 ? round($totalIndustri / count($aspekIndustri), 1) : 0;

        $totalSekolah = array_sum($aspekSekolah);
        $rataSekolah  = count($aspekSekolah) > 0 ? round($totalSekolah / count($aspekSekolah), 1) : 0;

        $allValues   = array_merge(array_values($aspekIndustri), array_values($aspekSekolah));
        $rataAll     = count($allValues) > 0 ? round(array_sum($allValues) / count($allValues), 1) : 0;
    @endphp

    <div class="tabel-wrapper">
        {{-- TABEL PENILAIAN INDUSTRI --}}
        <div>
            <div class="tabel-section-title">I. Penilaian Industri</div>
            <table class="tabel-nilai">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Aspek Yang Dinilai</th>
                        <th>Nilai</th>
                        <th>Kat.</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($aspekIndustri as $label => $val)
                    <tr>
                        <td style="text-align:center">{{ $loop->iteration }}</td>
                        <td>{{ $label }}</td>
                        <td style="text-align:center">{{ $val ?: '-' }}</td>
                        <td style="text-align:center">{{ $val >= 86 ? 'A' : ($val >= 70 ? 'B' : ($val >= 60 ? 'C' : ($val > 0 ? 'D' : '-'))) }}</td>
                    </tr>
                    @endforeach
                    <tr class="jumlah-row">
                        <td colspan="2" style="text-align:right">Jumlah Nilai</td>
                        <td style="text-align:center">{{ $totalIndustri }}</td>
                        <td></td>
                    </tr>
                    <tr class="rata-row">
                        <td colspan="2" style="text-align:right">Rata-rata</td>
                        <td style="text-align:center">{{ $rataIndustri }}</td>
                        <td style="text-align:center">{{ $rataIndustri >= 86 ? 'A' : ($rataIndustri >= 70 ? 'B' : ($rataIndustri >= 60 ? 'C' : 'D')) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- TABEL PENILAIAN SEKOLAH --}}
        <div>
            <div class="tabel-section-title">II. Penilaian Sekolah</div>
            <table class="tabel-nilai">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Aspek Yang Dinilai</th>
                        <th>Nilai</th>
                        <th>Kat.</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($aspekSekolah as $label => $val)
                    <tr>
                        <td style="text-align:center">{{ $loop->iteration }}</td>
                        <td>{{ $label }}</td>
                        <td style="text-align:center">{{ $val ?: '-' }}</td>
                        <td style="text-align:center">{{ $val >= 86 ? 'A' : ($val >= 70 ? 'B' : ($val >= 60 ? 'C' : ($val > 0 ? 'D' : '-'))) }}</td>
                    </tr>
                    @endforeach
                    <tr class="jumlah-row">
                        <td colspan="2" style="text-align:right">Jumlah Nilai</td>
                        <td style="text-align:center">{{ $totalSekolah }}</td>
                        <td></td>
                    </tr>
                    <tr class="rata-row">
                        <td colspan="2" style="text-align:right">Rata-rata</td>
                        <td style="text-align:center">{{ $rataSekolah }}</td>
                        <td style="text-align:center">{{ $rataSekolah >= 86 ? 'A' : ($rataSekolah >= 70 ? 'B' : ($rataSekolah >= 60 ? 'C' : 'D')) }}</td>
                    </tr>
                </tbody>
            </table>

            {{-- RATA-RATA AKHIR --}}
            <table class="tabel-nilai" style="margin-top:8px">
                <tr class="rata-row">
                    <td colspan="2" style="text-align:right; font-weight:bold">NILAI AKHIR (Rata-rata)</td>
                    <td style="text-align:center; font-weight:bold">{{ $rataAll }}</td>
                    <td style="text-align:center; font-weight:bold">{{ $rataAll >= 86 ? 'A' : ($rataAll >= 70 ? 'B' : ($rataAll >= 60 ? 'C' : 'D')) }}</td>
                </tr>
            </table>

            {{-- PREDIKAT --}}
            <table class="predikat-table" style="margin-top:10px">
                <tr><th>Nilai</th><th>Kategori</th><th>Keterangan</th></tr>
                <tr><td>86 - 100</td><td>A</td><td>Baik Sekali</td></tr>
                <tr><td>70 - 85</td><td>B</td><td>Baik</td></tr>
                <tr><td>60 - 69</td><td>C</td><td>Cukup</td></tr>
                <tr><td>50 - 59</td><td>D</td><td>Kurang</td></tr>
            </table>
        </div>
    </div>

    {{-- TTD BELAKANG --}}
    <div class="ttd-belakang">
        <div class="ttd-box">
            <div class="kota-tanggal">Pekanbaru, {{ \Carbon\Carbon::parse($pkl->tgl_selesai)->isoFormat('D MMMM Y') }}</div>
            <div class="kota-tanggal">Pembimbing PKL</div>
            <div class="nama-penandatangan">{{ $pkl->pembimbingIndustri->nama }}</div>
            <div class="jabatan">{{ $pkl->pembimbingIndustri->jabatan }}</div>
        </div>
    </div>
</div>

</body>
</html>
