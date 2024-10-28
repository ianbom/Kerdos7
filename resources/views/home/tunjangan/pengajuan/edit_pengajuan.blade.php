@extends('layouts.home.app')
@section('title', 'Pilih Periode Pengajuan Tunjangan')
@section('userTypeOnPage', 'SuperAdmin, OPPT')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Edit Data Dosen Yang Akan Diajukan </h4>

                    <form action="{{ route('oppt.updatePengajuan.dosen', $pengajuan->id_pengajuan) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <!-- Select Periode -->
                        <div class="mb-3">
                            <label for="id_periode" class="form-label">Periode:</label>
                            <p id="selected_periode" class="form-control">
                                <strong>{{ $pengajuan->periode->nama_periode }}</strong>
                            </p>
                        </div>

                        <!-- Checkbox untuk dosen -->
                        <div class="mb-3">
                            <label class="form-label">Pilih Dosen</label>
                            @foreach ($dosen as $dosen)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="dosen_ids[]" value="{{ $dosen->id }}"
                                    {{ $pengajuan->user->contains($dosen->id) ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ $dosen->name }}</label>
                                </div>
                            @endforeach
                        </div>

                        <button type="submit" class="btn btn-primary">Update Pengajuan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection