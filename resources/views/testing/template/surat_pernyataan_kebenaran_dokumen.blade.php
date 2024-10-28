<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <style>
        /* General styling for the PDF layout */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            max-width: 850px;
            margin: auto;
            box-sizing: border-box;
        }

        .container {
            padding: 20px;
            position: relative;
            text-align: center;
        }

        /* Header image styling */
        .header img {
            width: 100%;
            max-height: 150px;
            object-fit: contain;
        }

        /* Title text styling */
        .title {
            font-size: 1.2em;
            font-weight: bold;
            text-decoration: underline;
            margin-top: 20px;
            margin-bottom: 20px;
            text-align: center;
            border-top: 2px solid #900; /* Adds a top border */
            padding-top: 10px;
        }

        /* Content section styling */
        .content {
            padding: 10px;
            text-align: justify;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        /* Table styling for personal information */
        .info-table {
            width: 100%;
            margin-bottom: 20px;
        }

        .info-table td {
            padding: 4px;
            vertical-align: top;
        }

        .info-table td:first-child {
            width: 150px;
        }

        /* Signature section styling */
        .signature-section {
            text-align: right;
            margin-top: 50px;
            text-align: center;
        }

        .signature-section img {
            height: 100px;
            display: block;
            margin: 0 auto;
        }

        .signature-section p {
            margin-top: 5px;
        }

        /* Footer image styling */
        .footer {
            margin-top: 20px;
            border-bottom: 2px solid #900; /* Adds a bottom border */
            padding-bottom: 10px;
        }

        .footer img {
            width: 100%;
            max-height: 100px;
            object-fit: contain;
            margin-top: 20px;
        }
    </style>
</head>

<body>

    <!-- Header Image -->
    <div class="header">
        <img src="data:image/png;base64,{{ $headerImage }}" alt="Header Image">
    </div>

    <!-- Title Text -->
    <div class="title">
        {{ $title }}
    </div>

    <!-- Main Content Section -->
    <div class="content">
        <!-- Information Table -->
        <table class="info-table">
            <tr>
                <td>Nama</td>
                <td>: {{ $nama }}</td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td>: {{ $jabatan }}</td>
            </tr>
            <tr>
                <td>Nama PTS</td>
                <td>: {{ $namaPTS }}</td>
            </tr>
            <tr>
                <td>Alamat PTS</td>
                <td>: {{ $alamatPTS }}</td>
            </tr>
            <tr>
                <td>Nomor HP/Telp</td>
                <td>: {{ $nomor }}</td>
            </tr>
        </table>

        <!-- Statement Section -->
        <p>Dengan ini menyatakan dengan sebenarnya dan sesungguhnya bahwa semua data, informasi dan dokumen yang saya
            sampaikan adalah benar dan sesuai dengan aslinya.</p>

        <p>Apabila dikemudian hari ditemukan data, informasi dan dokumen yang tidak benar dan/atau ada pemalsuan, maka
            saya bersedia bertanggung jawab sepenuhnya dan bersedia dikenakan sanksi yang berlaku.</p>

        <p>Demikian Surat Pernyataan ini saya buat dengan sebenarnya tanpa ada tekanan dari pihak lain dan disusun
            sebagai kelengkapan berkas Laporan Beban Kerja Dosen Semester <strong>Genap 2023-2024</strong>.</p>

        <!-- Signature Section -->
        <div class="signature-section">
            <p>{{ $tanggal }}</p>
            <p>{{ $jabatan }}</p>
            <img src="#" alt="Stamp Image">
            <p>{{ $nama }}</p>
        </div>
    </div>

    <!-- Footer Image -->
    <div class="footer">
        <img src="data:image/png;base64,{{ $footerImage }}" alt="Footer Image">
    </div>
</body>

</html>
