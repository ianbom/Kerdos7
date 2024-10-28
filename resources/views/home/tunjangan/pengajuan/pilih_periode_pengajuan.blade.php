@extends('layouts.home.app')
@section('title', 'Pilih Periode Pengajuan Tunjangan')
@section('userTypeOnPage', 'SuperAdmin, OPPT')

@section('content')
<div class="content-wrapper">
    <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Buat Ajuan Dosen</h4>
                        <p class="card-description">
                            Lorem ipsum dolor sit
                        </p>
                        <!-- Success Message -->
                        <div class="alert alert-success" style="display: none;">
                            <!-- Success message can be shown here if needed -->
                        </div>
                        <!-- Error Messages -->
                        <div class="alert alert-danger" style="display: none;">
                            <ul>
                                <li>Error example 1</li>
                                <li>Error example 2</li>
                            </ul>
                        </div>
                        
                        <!-- <div class="content-wrapper" style="background-color: transparent;">
                            <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview">
                                <div class="row">
                                    <div class="col-lg-4 mb-3">
                                        <div class="card border-dark mb-3" style="max-width: 18rem; position: relative; padding-bottom: 40px;">
                                            <div class="card-header">Pelaporan Semester</div>
                                            <div class="card-body text-dark">
                                                <h5 class="card-title">Pelaporan BKD Agustus 2024</h5>
                                                <p class="card-text">Jadwal Pengisian Pelaporan</p>
                                            </div>
                                            <button class="btn btn-dark mt-2" style="position: absolute; bottom: 10px; right: 10px;">Button</button>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-4 mb-3">
                                        <div class="card border-dark mb-3" style="max-width: 18rem; position: relative; padding-bottom: 40px;">
                                            <div class="card-header">Pengajuan Bulanan</div>
                                            <div class="card-body text-dark">
                                                <h5 class="card-title">Pengajuan Tunjangan Dosen</h5>
                                                <p class="card-text">Jadwal Pengajuan</p>
                                            </div>
                                            <button class="btn btn-dark mt-2" style="position: absolute; bottom: 10px; right: 10px;">Button</button>
                                        </div>
                                    </div>
                                    
                                    Card tambahan lainnya jika diperlukan
                                    <div class="col-lg-4 mb-3">
                                        <div class="card border-dark mb-3" style="max-width: 18rem; position: relative; padding-bottom: 40px;">
                                            <div class="card-header">Card Tambahan</div>
                                            <div class="card-body text-dark">
                                                <h5 class="card-title">Contoh Card Tambahan</h5>
                                                <p class="card-text">Contoh isi dari card tambahan.</p>
                                            </div>
                                            <button class="btn btn-dark mt-2" style="position: absolute; bottom: 10px; right: 10px;">Button</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->

                        <div class="content-wrapper" style="background-color: transparent;">
                            <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview">
                                <div class="row">
                                    @foreach ($periode as $p)
                                        <div class="col-lg-4 mb-3">
                                            <div class="card border-dark mb-3" style="max-width: 18rem; position: relative; padding-bottom: 40px;">
                                            <div class="card-header">
                                                @if ($p->tipe_periode)
                                                    Pelaporan Semester
                                                @else
                                                    Pengajuan Tunjangan
                                                @endif
                                            </div>
                                                <div class="card-body text-dark">
                                                    <h5 class="card-title">{{ $p->nama_periode }}</h5>
                                                    <p class="card-text">Masa Periode:<br> {{ $p->masa_periode_awal }} hingga {{ $p->masa_periode_berakhir }}</p>
                                                </div>
                                                <a href="{{ route('oppt.pengajuan.dosen', $p->id_periode) }}" class="btn btn-success btn-sm mt-2" style="position: absolute; bottom: 10px; right: 10px;">Pilih</a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- <div class="content-wrapper">
        <div class="row justify-content-center">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Pilih Periode Pengajuan</h4>

                        @foreach ($periode as $p)
                            <p>{{ $p->nama_periode }}</p>
                            <a href="{{ route('oppt.pengajuan.dosen', $p->id_periode) }}"> pilih</a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div> -->

<style>
    .card {
    transition: transform 0.3s ease, box-shadow 0.3s ease; /* Untuk animasi transformasi dan bayangan */
}

.card:hover {
    transform: translateY(-10px); /* Mengangkat card sedikit ke atas saat hover */
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2); /* Menambahkan bayangan untuk efek kedalaman */
}

</style>
@endsection
