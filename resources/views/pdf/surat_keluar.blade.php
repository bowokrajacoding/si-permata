<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Keluar</title>
    <style>
        body { font-family: 'Times New Roman', serif; line-height: 1.5; font-size: 14px; }
        .kop { text-align: center; border-bottom: 2px solid black; margin-bottom: 10px; }
        .content { margin-top: 20px; }
    </style>
</head>
<body>
    <div class="kop">
        <h2>PUSKESMAS SEHAT SELALU</h2>
        <p>Jl. Puskesmas No.1, Kesehatan Raya, Indonesia</p>
    </div>
    <div class="content">
        <p><strong>Nomor:</strong> {{ $surat->nomor }}</p>
        <p><strong>Tujuan:</strong> {{ $surat->tujuan }}</p>
        <p><strong>Perihal:</strong> {{ $surat->perihal }}</p>
        <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($surat->tanggal)->translatedFormat('d F Y') }}</p>

        <br>
        <p>{{ $surat->isi }}</p>

        <br><br>
        <p style="text-align:right;">Hormat Kami,<br><strong>Pimpinan Puskesmas</strong></p>
    </div>
</body>
</html>
