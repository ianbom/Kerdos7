@extends('layouts.home.app')
@section('title', 'Bank')
@section('userTypeOnPage', 'SuperAdmin, Perencanaan')
@section('content')
    <div class="content-wrapper">
        <div class="home-tab">

            <div class="d-sm-flex align-items-center justify-content-between border-bottom">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active ps-0" id="home-tab" data-bs-toggle="tab" href="#overview" role="tab"
                            aria-controls="overview" aria-selected="true">Detail Bank</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#audiences" role="tab"
                            aria-selected="false">Buat Bank</a>
                    </li>
                </ul>
            </div>

            {{-- modal edit --}}
            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Edit Bank</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="editBankForm">
                                @csrf
                                @method('PUT')
                                <input type="hidden" id="edit_id_bank" name="id_bank">

                                <div class="form-group">
                                    <label for="edit_nama_bank">Nama Bank</label>
                                    <input type="text" class="form-control" id="edit_nama_bank" name="nama_bank"
                                        required>
                                </div>

                                <div class="form-group">
                                    <label for="status">Status :</label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary">Perbarui</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-content tab-content-basic">
                <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview">
                    <div class="row">
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                <div id="success-message" class="alert alert-success" style="display:none;"></div>

                                <div id="error-message" class="alert alert-danger" style="display:none;">
                                    <ul id="error-list"></ul>
                                </div>

                                    <h4 class="card-title">Data Bank</h4>

                                    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal"
                                        data-bs-target="#createModal">
                                        Create Bank
                                    </button>

                                    <div class="table-responsive" id="pagination-data">
                                        @if ($bank->isEmpty())
                                            <div class="alert alert-warning text-center">
                                                <strong>Tidak Ada Data yang ditemukan</strong>
                                            </div>
                                        @else
                                            @include('home.anggota.komponen.pagination_bank')
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="createModalLabel">Create Bank</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">

                                        <form id="createBankForm">
                                            @csrf
                                            <div class="form-group">
                                                <label for="nama_bank">Nama Bank</label>
                                                <input type="text" class="form-control" id="nama_bank"
                                                    name="nama_bank" value="{{ old('nama_bank') }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="status">Status:</label>
                                                <select name="status" id="status" class="form-select" required>
                                                    <option value="1">Active</option>
                                                </select>
                                            </div>

                                            <button type="submit" class="btn btn-success">Save</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>

        <div class="home-tab">

            <div class="tab-content tab-content-basic">
                <div class="tab-pane fade show" id="audiences" role="tabpanel" aria-labelledby="audiences">

                    <div class="row justify-content-center">
                        <div class="col-md-6 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Buat Bank Baru</h4>
                                    <div class="row">
                                        <form action="{{ route('bank.create') }}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label for="nama_bank">Nama Bank:</label>
                                                <input type="text" name="nama_bank" id="nama_bank" class="form-control"
                                                    value="{{ old('nama_bank') }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="status" class="form-label">Status:</label>
                                                <select name="status" id="status" class="form-control" required>
                                                    <option value="1" selected>Active</option>
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-primary mb-2">Buat</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        var currentStatus = '';

        $('#createBankForm').on('submit', function(e) {
                e.preventDefault();

                $('#success-message').hide();
                $('#error-message').hide();
                $('#error-list').empty();

                var formData = $(this).serialize();

                $.ajax({
                    url: '{{ route('bank.create') }}',
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response) {
                            location.reload();
                        }
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;
                        if (errors) {
                            for (var error in errors) {
                                $('#error-list').append(`<li>${errors[error][0]}</li>`);
                            }
                            $('#error-message').show();
                        }
                    }
                });
            });

         $(document).on('click', '.edit-btn', function() {
                var id = $(this).data('id');
                var nama = $(this).data('nama');
                var status = $(this).data('status');

                $('#edit_id_bank').val(id);
                $('#edit_nama_bank').val(nama);
                $('#edit_status').val(status);

                $('#editModal').modal('show');
            });


        $('#editBankForm').on('submit', function(e) {
            e.preventDefault();

            var formData = $(this).serialize();
            var id = $('#edit_id_bank').val();

            $.ajax({
                url: '{{ route('bank.update', '') }}/' + id,
                method: 'POST',
                data: formData,
                success: function(response) {

                    location.reload();
                },
                error: function(xhr) {

                    alert('Terjadi kesalahan');
                }
            });
        });

        $(document).on('click', '.status-filter-option', function(e) {
                e.preventDefault();
                currentStatus = $(this).data('status');
                fetch_data(1, currentStatus);
        });

        function fetch_data(page, status = '') {
                var search = $('#search').val();

                $.ajax({
                    url: "{{ route('index.bank') }}?page=" + page + "&search=" + search + "&status=" +
                        status,
                    success: function(data) {
                        $('#pagination-data').html(data
                            .html); // Masukkan respons HTML ke elemen pagination-data
                    },
                    error: function(xhr, status, error) {
                        console.error("Error: " + xhr.responseText);
                    }
                });
        }
    });
</script>
@endsection
