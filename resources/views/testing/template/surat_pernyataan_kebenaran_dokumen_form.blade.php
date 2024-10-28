<!-- resources/views/pdf_form.blade.php -->

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Input Surat Keaslian Dokumen</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Form Input Surat Keaslian Dokumen</h1>
        <form action="{{ route('generate-pdf') }}" method="POST" enctype="multipart/form-data" class="bg-light p-4 rounded shadow">
            @csrf

            <div class="mb-3">
                <laebel for="title" class="form-label">Title</laebel>
                <input type="text" class="form-control" name="title" id="title" value="SURAT PERNYATAAN KEBENARAN DAN KEASLIAN DOKUMEN" required>
            </div>

            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" name="nama" id="nama" required>
            </div>

            <div class="mb-3">
                <label for="jabatan" class="form-label">Jabatan</label>
                <input type="text" class="form-control" name="jabatan" id="jabatan" required>
            </div>

            <div class="mb-3">
                <label for="namaPTS" class="form-label">Nama PTS</label>
                <input type="text" class="form-control" name="namaPTS" id="namaPTS" required>
            </div>

            <div class="mb-3">
                <label for="alamatPTS" class="form-label">Alamat PTS</label>
                <input type="text" class="form-control" name="alamatPTS" id="alamatPTS" required>
            </div>

            <div class="mb-3">
                <label for="nomor" class="form-label">Nomor HP/Telp</label>
                <input type="text" class="form-control" name="nomor" id="nomor" required>
            </div>

            <div class="mb-3">
                <label for="tanggal" class="form-label">Tanggal</label>
                <input type="text" class="form-control" name="tanggal" id="tanggal" required>
            </div>

            <div class="mb-3">
                <label for="headerImage" class="form-label">Header Image</label>
                <input type="file" class="form-control" name="headerImage" id="headerImage" accept="image/*" required>
            </div>

            <div class="mb-3">
                <label for="footerImage" class="form-label">Footer Image</label>
                <input type="file" class="form-control" name="footerImage" id="footerImage" accept="image/*" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Generate PDF</button>
        </form>
    </div>

    <!-- Bootstrap JS and dependencies (optional for interactive components) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
