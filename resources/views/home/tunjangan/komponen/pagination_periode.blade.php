<table class="table table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Nama Periode</th>
            <th>
                <div class="dropdown">
                    <a href="#" id="tipePeriodeDropdown" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="text-decoration: none; color: inherit;">
                        Tipe Periode
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="tipePeriodeDropdown">
                        <li><a class="dropdown-item tipe-filter-option" href="#" data-tipe="">Semua Tipe</a></li>
                        <li><a class="dropdown-item tipe-filter-option" href="#" data-tipe="0">Semester</a></li>
                        <li><a class="dropdown-item tipe-filter-option" href="#" data-tipe="1">Bulanan</a></li>
                    </ul>
                </div>
            </th>
            <th>BKD dari</th>
            <th>Masa Periode Awal</th>
            <th>Masa Periode Berakhir</th>
            <th>
                <div class="dropdown">
                    <a href="#" id="statusDropdown" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="text-decoration: none; color: inherit;">
                        Status
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="statusDropdown">
                        <li><a class="dropdown-item status-filter-option" href="#" data-status="">Semua Status</a></li>
                        <li><a class="dropdown-item status-filter-option" href="#" data-status="1">Aktif</a></li>
                        <li><a class="dropdown-item status-filter-option" href="#" data-status="0">Tidak Aktif</a></li>
                    </ul>
                </div>
            </th>
            <th>Edit</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($periodes as $item)
            <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td>{{ $item->nama_periode }}</td>
                <td>
                    @if ($item->tipe_periode == 1)
                    <span class="badge bg-info">Bulanan</span>
                    @else
                    <span class="badge bg-success">Semester</span>
                    @endif
                </td>
                <td>{{ $item->parentPeriode && $item->parentPeriode->nama_periode ? $item->parentPeriode->nama_periode : 'BKD Baru' }}</td>
                <td>{{ \Carbon\Carbon::parse($item->masa_periode_awal)->translatedFormat('d F Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($item->masa_periode_berakhir)->translatedFormat('d F Y') }}</td>
                <td>
                    @if ($item->status == 1)
                        <span class="badge bg-success">Aktif</span>
                    @else
                        <span class="badge bg-danger">Tidak Aktif</span>
                    @endif
                </td>
                <td>
                    <button type="button" class="btn btn-warning btn-sm edit-btn text-white"
                        data-id="{{ $item->id_periode }}" data-nama_periode="{{ $item->nama_periode }}"
                        data-tipe_periode="{{ $item->tipe_periode }}"
                        data-masa_periode_awal="{{ $item->masa_periode_awal }}"
                        data-masa_periode_berakhir="{{ $item->masa_periode_berakhir }}"
                        data-id_child="{{ $item->id_child }}"
                        data-status="{{ $item->status }}" data-bs-toggle="modal"
                        data-bs-target="#editModal">Edit</button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>


<div class="pagination-links">
    {{ $periodes->links() }}
</div>
