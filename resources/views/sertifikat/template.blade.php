<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
        }

        /* ======================== */
        /* HALAMAN DEPAN            */
        /* ======================== */
        .halaman-depan {
            width: 297mm;
            height: 210mm;
            padding: 12mm 18mm;
            border: 10px solid #c8a84b;
            outline: 3px solid #c8a84b;
            outline-offset: -14px;
            background: #fffdf5;
            text-align: center;
            position: relative;
            page-break-after: always;
        }

        .judul {
            font-size: 38pt;
            font-weight: bold;
            color: #c8a84b;
            letter-spacing: 5px;
            text-transform: uppercase;
            margin-bottom: 2px;
            margin-top: 10px;
        }

        .sub-judul {
            font-size: 13pt;
            color: #8B6914;
            letter-spacing: 3px;
            text-transform: uppercase;
            padding-bottom: 10px;
            border-bottom: 2px solid #c8a84b;
            display: inline-block;
            margin-bottom: 18px;
        }

        .label-kepada {
            font-size: 11pt;
            color: #555;
            margin-bottom: 6px;
        }

        .nama-siswa {
            font-size: 26pt;
            font-weight: bold;
            color: #1a4a8a;
            text-transform: uppercase;
            letter-spacing: 2px;
            text-decoration: underline;
            margin-bottom: 16px;
        }

        .info-siswa {
            font-size: 11pt;
            color: #333;
            line-height: 1.8;
            margin-bottom: 8px;
        }

        .nama-industri {
            font-size: 18pt;
            font-weight: bold;
            color: #c0392b;
            margin: 4px 0 6px;
        }

        .periode {
            font-size: 11pt;
            color: #333;
            margin-bottom: 3px;
        }

        .catatan-nilai {
            font-size: 10pt;
            color: #555;
            margin-bottom: 16px;
        }

        .ttd-area {
            position: absolute;
            bottom: 14mm;
            right: 18mm;
            text-align: center;
            width: 180px;
        }

        .ttd-kota {
            font-size: 10pt;
            color: #333;
        }

        .ttd-instansi {
            font-size: 10pt;
            color: #333;
            margin-bottom: 50px; /* ruang tanda tangan kosong */
        }

        .ttd-nama {
            font-size: 10pt;
            font-weight: bold;
            border-top: 1px solid #333;
            padding-top: 4px;
        }

        .ttd-jabatan {
            font-size: 9pt;
            color: #555;
        }

        /* ======================== */
        /* HALAMAN BELAKANG         */
        /* ======================== */
        .halaman-belakang {
            width: 297mm;
            height: 210mm;
            padding: 10mm 14mm;
            background: #ffffff;
        }

        .belakang-judul {
            text-align: center;
            font-size: 13pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
            text-decoration: underline;
        }

        .info-header {
            width: 100%;
            border-collapse: collapse;
            font-size: 10pt;
            margin-bottom: 10px;
        }

        .info-header td {
            padding: 1px 4px;
            font-size: 10pt;
        }

        /* Wrapper 2 kolom tabel nilai */
        .nilai-wrapper {
            display: table;
            width: 100%;
            table-layout: fixed;
        }

        .nilai-col {
            display: table-cell;
            vertical-align: top;
            padding-right: 6mm;
        }

        .nilai-col:last-child {
            padding-right: 0;
        }

        .section-title {
            font-size: 10pt;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 4px;
        }

        .tabel-nilai {
            width: 100%;
            border-collapse: collapse;
            font-size: 9.5pt;
            margin-bottom: 6px;
        }

        .tabel-nilai th {
            background-color: #2c5f9e;
            color: white;
            padding: 4px 6px;
            text-align: center;
            font-size: 9pt;
            border: 1px solid #2c5f9e;
        }

        .tabel-nilai td {
            border: 1px solid #bbb;
            padding: 4px 6px;
            font-size: 9.5pt;
        }

        .row-jumlah td {
            font-weight: bold;
            background-color: #f5f5f5;
        }

        .row-rata td {
            font-weight: bold;
            background-color: #dce8fb;
        }

        .row-akhir td {
            font-weight: bold;
            background-color: #d4edda;
        }

        .predikat-table {
            border-collapse: collapse;
            font-size: 9pt;
            margin-top: 8px;
        }

        .predikat-table th,
        .predikat-table td {
            border: 1px solid #bbb;
            padding: 3px 8px;
            text-align: center;
        }

        .predikat-table th {
            background-color: #e0e0e0;
            font-weight: bold;
        }

        .ttd-belakang {
            text-align: center;
            width: 180px;
            float: right;
            margin-top: 8px;
        }

        .ttd-belakang .ttd-nama {
            font-size: 10pt;
            font-weight: bold;
            border-top: 1px solid #333;
            padding-top: 4px;
            margin-top: 45px;
        }

        .ttd-belakang .ttd-jabatan {
            font-size: 9pt;
            color: #555;
        }
    </style>
</head>
<body>

@php
    $nilai       = $pkl->nilai;
    $tglSelesai  = \Carbon\Carbon::parse($pkl->tgl_selesai);
    $tglMulai    = \Carbon\Carbon::parse($pkl->tgl_mulai);

    $aspekIndustri = [
        'Soft Skills Dunia Kerja'    => $nilai->aspek_soft_skills ?? 0,
        'Norma, POS & K3LH'          => $nilai->aspek_norma_k3lh ?? 0,
        'Kompetensi Teknis'          => $nilai->aspek_kompetensi_teknis ?? 0,
        'Wawasan Bisnis & Wirausaha' => $nilai->aspek_wawasan_bisnis ?? 0,
    ];

    $aspekSekolah = [
        'Penyusunan Laporan PKL' => $nilai->aspek_penyusunan_laporan ?? 0,
        'Presentasi Hasil PKL'   => $nilai->aspek_presentasi ?? 0,
    ];

    $totalIndustri = array_sum($aspekIndustri);
    $rataIndustri  = round($totalIndustri / count($aspekIndustri), 1);

    $totalSekolah = array_sum($aspekSekolah);
    $rataSekolah  = round($totalSekolah / count($aspekSekolah), 1);

    $allValues = array_merge(array_values($aspekIndustri), array_values($aspekSekolah));
    $rataAll   = round(array_sum($allValues) / count($allValues), 1);

    function kategori($val) {
        if ($val >= 86) return 'A';
        if ($val >= 70) return 'B';
        if ($val >= 60) return 'C';
        return 'D';
    }
@endphp

{{-- ===================== --}}
{{-- HALAMAN DEPAN         --}}
{{-- ===================== --}}
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
        Periode {{ $tglMulai->isoFormat('MMMM Y') }} – {{ $tglSelesai->isoFormat('MMMM Y') }}
    </div>
    <div class="catatan-nilai">Dengan Nilai Tercantum Di Belakang Sertifikat Ini.</div>

    <div class="ttd-area">
        <div class="ttd-kota">Pekanbaru, {{ $tglSelesai->isoFormat('D MMMM Y') }}</div>
        <div class="ttd-instansi">{{ $pkl->industri->nama }}</div>
        <div class="ttd-nama">{{ $pkl->pembimbingIndustri->nama }}</div>
        <div class="ttd-jabatan">{{ $pkl->pembimbingIndustri->jabatan }}</div>
    </div>
</div>

{{-- ===================== --}}
{{-- HALAMAN BELAKANG      --}}
{{-- ===================== --}}
<div class="halaman-belakang">
    <div class="belakang-judul">Daftar Nilai Praktik Kerja Lapangan (PKL)</div>

    <table class="info-header">
        <tr>
            <td width="130">Nama</td>
            <td width="5">:</td>
            <td><strong>{{ $pkl->siswa->nama }}</strong></td>
            <td width="140">Tempat PKL</td>
            <td width="5">:</td>
            <td><strong>{{ $pkl->industri->nama }}</strong></td>
        </tr>
        <tr>
            <td>Nomor Induk Siswa</td>
            <td>:</td>
            <td>{{ $pkl->siswa->nisn }}</td>
            <td>Kompetensi Keahlian</td>
            <td>:</td>
            <td>{{ $pkl->siswa->jurusan }}</td>
        </tr>
    </table>

    <div class="nilai-wrapper">

        {{-- KOLOM KIRI: PENILAIAN INDUSTRI --}}
        <div class="nilai-col">
            <div class="section-title">I. Penilaian Industri</div>
            <table class="tabel-nilai">
                <thead>
                    <tr>
                        <th width="30">No.</th>
                        <th>Aspek Yang Dinilai</th>
                        <th width="45">Nilai</th>
                        <th width="35">Kat.</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($aspekIndustri as $label => $val)
                    <tr>
                        <td style="text-align:center">{{ $loop->iteration }}</td>
                        <td>{{ $label }}</td>
                        <td style="text-align:center">{{ $val ?: '-' }}</td>
                        <td style="text-align:center">{{ $val ? kategori($val) : '-' }}</td>
                    </tr>
                    @endforeach
                    <tr class="row-jumlah">
                        <td colspan="2" style="text-align:right">Jumlah Nilai</td>
                        <td style="text-align:center">{{ $totalIndustri }}</td>
                        <td></td>
                    </tr>
                    <tr class="row-rata">
                        <td colspan="2" style="text-align:right">Rata-rata</td>
                        <td style="text-align:center">{{ $rataIndustri }}</td>
                        <td style="text-align:center">{{ kategori($rataIndustri) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- KOLOM KANAN: PENILAIAN SEKOLAH --}}
        <div class="nilai-col">
            <div class="section-title">II. Penilaian Sekolah</div>
            <table class="tabel-nilai">
                <thead>
                    <tr>
                        <th width="30">No.</th>
                        <th>Aspek Yang Dinilai</th>
                        <th width="45">Nilai</th>
                        <th width="35">Kat.</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($aspekSekolah as $label => $val)
                    <tr>
                        <td style="text-align:center">{{ $loop->iteration }}</td>
                        <td>{{ $label }}</td>
                        <td style="text-align:center">{{ $val ?: '-' }}</td>
                        <td style="text-align:center">{{ $val ? kategori($val) : '-' }}</td>
                    </tr>
                    @endforeach
                    <tr class="row-jumlah">
                        <td colspan="2" style="text-align:right">Jumlah Nilai</td>
                        <td style="text-align:center">{{ $totalSekolah }}</td>
                        <td></td>
                    </tr>
                    <tr class="row-rata">
                        <td colspan="2" style="text-align:right">Rata-rata</td>
                        <td style="text-align:center">{{ $rataSekolah }}</td>
                        <td style="text-align:center">{{ kategori($rataSekolah) }}</td>
                    </tr>
                </tbody>
            </table>

            {{-- NILAI AKHIR --}}
            <table class="tabel-nilai">
                <tr class="row-akhir">
                    <td colspan="2" style="text-align:right; font-weight:bold">NILAI AKHIR</td>
                    <td style="text-align:center; font-weight:bold">{{ $rataAll }}</td>
                    <td style="text-align:center; font-weight:bold">{{ kategori($rataAll) }}</td>
                </tr>
            </table>

            {{-- PREDIKAT --}}
            <table class="predikat-table">
                <tr>
                    <th>Nilai</th><th>Kategori</th><th>Keterangan</th>
                </tr>
                <tr><td>86 - 100</td><td>A</td><td>Baik Sekali</td></tr>
                <tr><td>70 - 85</td><td>B</td><td>Baik</td></tr>
                <tr><td>60 - 69</td><td>C</td><td>Cukup</td></tr>
                <tr><td>50 - 59</td><td>D</td><td>Kurang</td></tr>
            </table>

            {{-- TTD BELAKANG --}}
            <div class="ttd-belakang">
                <div class="ttd-kota">Pekanbaru, {{ $tglSelesai->isoFormat('D MMMM Y') }}</div>
                <div style="font-size:10pt">Pembimbing PKL</div>
                <div class="ttd-nama">{{ $pkl->pembimbingIndustri->nama }}</div>
                <div class="ttd-jabatan">{{ $pkl->pembimbingIndustri->jabatan }}</div>
            </div>
        </div>

    </div>{{-- end nilai-wrapper --}}
</div>

</body>
</html>
