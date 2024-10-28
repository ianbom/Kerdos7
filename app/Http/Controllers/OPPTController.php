<?php

namespace App\Http\Controllers;

use App\Models\Gapok;
use App\Models\Jabatan_Fungsional;
use App\Models\Pangkat_Dosen;
use App\Models\Pengajuan;
use App\Models\Pengajuan_Dokumen;
use App\Models\Periode;
use App\Models\Permohonan;

use App\Models\Role;
use App\Models\Universitas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class OPPTController extends Controller
{
    public function historyPengajuanDosen($id){
        $dosen = User::with('pengajuan')->findOrFail($id);
        //return response()->json(['Data' => $dosen]);
        return view('home.tunjangan.pengajuan.riwayat_pengajuan', ['dosen'=>$dosen]);
    }

    // public function historyPengajuanDosen($id){
    //     $dosen = User::with('pengajuan')->findOrFail($id);
    //     //return response()->json(['Data' => $dosen]);
    //     return view('testing.oppt.history_dosen_pengajuan', ['dosen'=>$dosen]);
    // }

    // public function allDosen(Request $request)
    // {
    //     $oppt = Auth::user();
    //     if ($oppt->id_role == 1 | 2 | 3 ) {
    //          $dosen = User::where('id_role', 5)->get();

    //     } if ($oppt->id_role == 7) {
    //         $dosen = User::where('id_universitas', $oppt->id_universitas)->get();
    //     }

    //     return view('home.anggota.dosen.data_dosen_oppt', ['dosen' => $dosen]);
    // }

    public function allDosen(Request $request)
    {
        $statusFilter = $request->input('status');

        // dd($request->ajax());
        $oppt = Auth::user();

        // Role-based filtering for the dosen data
        if (in_array($oppt->id_role, [1, 2, 3])) {
            $dosen = User::where('id_role', 5)
                ->when(isset($statusFilter) && ($statusFilter === 'aktif' || $statusFilter === 'non-aktif' || $statusFilter === 'pensiun' || $statusFilter === 'belajar'), function ($query) use ($statusFilter) {
                    $query->where('status', $statusFilter);  // Conditional filtering based on status
                })
                ->orderBy('created_at', 'desc')
                ->paginate(5);

            if ($request->ajax()) {
                if ($dosen->isEmpty()) {
                    return response()->json(['html' => view('home.anggota.komponen.data_kosong')->render()]);
                } else {
                    return response()->json([
                        'html' => view('home.anggota.dosen.pagination_dosen_oppt', compact('dosen'))->render(),
                    ]);
                }
            }
        }

        if ($oppt->id_role == 7) {
            $dosen = User::where('id_universitas', $oppt->id_universitas)
                ->when(isset($statusFilter) && ($statusFilter === 'aktif' || $statusFilter === 'non-aktif' || $statusFilter === 'pensiun' || $statusFilter === 'belajar'), function ($query) use ($statusFilter) {
                    $query->where('status', $statusFilter);  // Conditional filtering based on status
                })
                ->orderBy('created_at', 'desc')
                ->paginate(5);

            if ($request->ajax()) {
                if ($dosen->isEmpty()) {
                    return response()->json(['html' => view('home.anggota.komponen.data_kosong')->render()]);
                } else {
                    return response()->json([
                        'html' => view('home.anggota.dosen.pagination_dosen_oppt', compact('dosen'))->render(),
                    ]);
                }
            }
        }

        return view('home.anggota.dosen.data_dosen_oppt', ['dosen' => $dosen]);
    }




    // public function allDosen()
    // {
    //     $oppt = Auth::user();
    //     $dosen = User::all()

    //         // ->where('id_role', 5)
    //         ->where('id_universitas', $oppt->id_universitas);
    //     //return response()->json(['dosen' => $dosen]);
    //     return view('testing.oppt.index_dosen', ['dosen' => $dosen]);
    // }

    public function updateStatusDosen(Request $request, $id)
    {
        $dosen = User::findOrFail($id);
        $request->validate([
            'status' => 'required|in:aktif,non-aktif,pensiun,belajar',
        ]);

        $dosen->status = $request->status;
        $dosen->save();

        return redirect()->back()->with('success', 'Status dosen berhasil diperbarui.');
    }

    // public function editDosen($id)
    // {
    //     $dosen = User::findOrFail($id);
    //     $gelar_depan = Gelar_Depan::all();
    //     $gelar_belakang = Gelar_Belakang::all();
    //     $jabatan_fungsional = Jabatan_Fungsional::all();
    //     $pangkat_dosen = Pangkat_Dosen::all();
    //     $universitas = Universitas::all();
    //     $prodi = Prodi::all();

    //     return view(
    //         'testing.oppt.edit_dosen',
    //         [
    //             'dosen' => $dosen,
    //             'gelar_depan' => $gelar_depan,
    //             'gelar_belakang' => $gelar_belakang,
    //             'jabatan_fungsional' => $jabatan_fungsional,
    //             'pangkat_dosen' => $pangkat_dosen,
    //             'universitas' => $universitas,
    //             'prodi' => $prodi
    //         ]
    //     );
    // }

    public function editDosen($id)
    {
        $dosen = User::findOrFail($id);
        $jabatan_fungsional = Jabatan_Fungsional::all();
        $pangkat_dosen = Pangkat_Dosen::all();
        $universitas = Universitas::all();
        $gapok = Gapok::all();

        return view(
            'home.anggota.dosen.edit_dosen_oppt',   ////view page edit dosen
            [
                'dosen' => $dosen,
                'jabatan_fungsional' => $jabatan_fungsional,
                'pangkat_dosen' => $pangkat_dosen,
                'universitas' => $universitas,
                'gapok' => $gapok
            ]
        );
    }


    public function updateDosen(Request $request, $id)
    {
        try {
            $request->validate([
                'id_jabatan_fungsional' => 'nullable|exists:jabatan_fungsional,id_jabatan_fungsional',
                'id_pangkat_dosen' => 'nullable|exists:pangkat_dosen,id_pangkat_dosen',
                'id_universitas' => 'nullable|exists:universitas,id_universitas',
                'id_gapok' => 'nullable|exists:gapok,id_gapok',
                'gelar_depan' => 'nullable|string',
                'gelar_belakang' => 'nullable|string',
                'name' => 'required|string|max:255',
                'masa_kerja' => 'nullable|string',
                'awal_belajar' => 'nullable|string',
                'akhir_belajar' => 'nullable|string',
                'no_rek' => 'nullable|string|max:20',
                'nama_rekening' => 'nullable|string',
                'npwp' => 'nullable|string|max:20',
                'nidn' => 'nullable|string|max:20',
                'tanggal_lahir' => 'nullable|date',
                'tempat_lahir' => 'nullable|string|max:255',
                'tipe_dosen' => 'nullable|in:pns-gb,pns-profesi,non-gb,non-profesi',
                'file_serdos' => 'nullable|file|mimes:pdf|max:5048', // Validasi untuk file serdos (hanya PDF)
                'no_serdos' => 'nullable|string',
                'image' => 'nullable|image|max:2048', // Validasi untuk image (gambar)
            ]);

            $dosen = User::findOrFail($id);


            $dosen->id_jabatan_fungsional = $request->id_jabatan_fungsional;
            $dosen->id_pangkat_dosen = $request->id_pangkat_dosen;
            $dosen->id_universitas = $request->id_universitas;
            $dosen->id_gapok = $request->id_gapok;
            $dosen->gelar_depan = $request->gelar_depan;
            $dosen->gelar_belakang = $request->gelar_belakang;
            $dosen->name = $request->name;
            $dosen->masa_kerja = $request->masa_kerja;
            $dosen->awal_belajar = $request->awal_belajar;
            $dosen->akhir_belajar=$request->akhir_belajar;
            $dosen->no_rek = $request->no_rek;
            $dosen->nama_rekening = $request->nama_rekening;
            $dosen->npwp = $request->npwp;
            $dosen->nidn = $request->nidn;
            $dosen->tanggal_lahir = $request->tanggal_lahir;
            $dosen->tempat_lahir = $request->tempat_lahir;
            $dosen->tipe_dosen = $request->tipe_dosen;

            if ($request->hasFile('file_serdos')) {
                $fileSerdosPath = $request->file('file_serdos')->store('files/serdos', 'public');
                if ($dosen->file_serdos) {
                    Storage::disk('public')->delete($dosen->file_serdos);
                }
                $dosen->file_serdos = $fileSerdosPath;
            }

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('images/dosen', 'public');
                if ($dosen->image) {
                    Storage::disk('public')->delete($dosen->image);
                }
                $dosen->image = $imagePath;
            }
            $dosen->save();
            return redirect()->back();
        } catch (\Throwable $th) {
           return response()->json(['err'=> $th->getMessage()]);
        }

    }

    public function indexPeriode()
    {
        $periode = Periode::all();
        return view('home.tunjangan.komponen.data_periode', ['periode' => $periode]);
    }

    // public function indexPeriode()
    // {
    //     $periode = Periode::all();
    //     return view('testing.oppt.periode', ['periode' => $periode]);
    // }

    public function pilihPeriodePengajuan(){
        $periode = Periode::where('status', true)->get();
        return view('home.tunjangan.pengajuan.pilih_periode_pengajuan', ['periode' => $periode]);
    }


    public function addPengajuan($id)
{

    $periode = Periode::findOrFail($id);
    $oppt = Auth::user();

    if ($periode->tipe_periode == true) {

        $periodeId = $periode->id_child;

        $dosen = User::with('bkd')
        ->where('id_universitas', $oppt->id_universitas)
        ->where('status', 'aktif')
        ->whereHas('bkd', function ($query) use ($periodeId) {
            $query->where('kesimpulan_bkd', 'M')
                ->where('no_serdos', '!=', 'Belum tersertifikasi dosen')
                ->where(function ($q) {

                    $q->where('kewajiban_khusus', '!=', 'Tugas Belajar')
                      ->where('kewajiban_khusus', '!=', 'Tidak memiliki Fungsional');
                })
                ->where('id_periode', $periodeId);
        })
        ->with(['bkd' => function ($query) use ($periodeId) {

            $query->where('id_periode', $periodeId);
        }])
        ->orderBy('name', 'asc')
        ->get();

        //return response()->json(['periode' => $periode, 'dosen' => $dosen]);
        return view('home.tunjangan.pencairan_bulanan.create_pencairan_bulanan', ['periode' => $periode, 'dosen' => $dosen]);

    } else {
        $dosen = User::with('bkd')
        ->where('id_universitas', $oppt->id_universitas)
        ->where('status', 'aktif')
        ->whereHas('bkd', function ($query) use ($id) {
            $query->where('kesimpulan_bkd', 'M')
                ->where('no_serdos', '!=', 'Belum tersertifikasi dosen')
                ->where(function ($q) {

                    $q->where('kewajiban_khusus', '!=', 'Tugas Belajar')
                      ->where('kewajiban_khusus', '!=', 'Tidak memiliki Fungsional');
                })
                ->where('id_periode', $id);
        })
        ->with(['bkd' => function ($query) use ($id) {

            $query->where('id_periode', $id);
        }])
        ->orderBy('name', 'asc')
        ->get();

        //return response()->json(['dosen' => $dosen]);
    return view('home.tunjangan.pengajuan.buat_pengajuan', [
        'periode' => $periode,
        'dosen' => $dosen
    ]);

    }


}



public function searchNamaDosen(Request $request)
{
    $oppt = Auth::user();

    $query = User::where('id_universitas', $oppt->id_universitas)
        ->whereHas('bkd', function ($query) {
            $query->where('kesimpulan_bkd', 'M');
        })->with('bkd');

    if ($request->has('search') && !empty($request->search)) {
        $search = $request->search;
        // Modify the query to search by name or NIDN
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('nidn', 'like', "%{$search}%");
        });
    }

    $dosen = $query->get();

    $periode = Periode::all();

    return view('home.tunjangan.pengajuan.buat_pengajuan', [
        'periodes' => $periode,
        'dosen' => $dosen,
        'search' => $request->search
    ]);
}



    //     public function addPengajuan()
    // {
    //     $oppt = Auth::user();
    //     $dosen = User::all()
    //     ->where('id_universitas', $oppt->id_universitas);
    //     $periode = Periode::all();
    //     return view('testing.oppt.pengajuan', ['periodes' => $periode, 'dosen' => $dosen]);
    // }

    public function indexPengajuan()
    {
        $pengajuan = Pengajuan::with('user')->get();
        return view('home.tunjangan.pengajuan.index_pengajuan', compact('pengajuan'));
    }

    //public function indexPengajuan()
    //  {
    //        $pengajuan = Pengajuan::with('user')->get();
    //      return view('testing.oppt.index_pengajuan', compact('pengajuan'));
    //  }

    public function showPengajuan($id)
    {
        $pengajuan = Pengajuan::findOrFail($id);
        $jumlahDokumen = $pengajuan->pengajuan_dokumen->count();

        //return response()->json(['JumDOk' => $jumlahDokumen]);
        return view('home.tunjangan.pengajuan.ajukan_bulanan', ['pengajuan' => $pengajuan]);
    }

    // public function showPengajuan($id)
    // {
    //     $pengajuan = Pengajuan::findOrFail($id);
    //     $jumlahDokumen = $pengajuan->pengajuan_dokumen->count();

    //     //return response()->json(['JumDOk' => $jumlahDokumen]);
    //     return view('testing.oppt.show_pengajuan', ['pengajuan' => $pengajuan]);
    // }

    public function ajukanDosen(Request $request, $id)
    {
        try {
            $request->validate([
                'id_periode' => 'required',
                'dosen_ids' => 'required|array',
            ]);

            $periode = Periode::findOrFail($id);

            $pengajuan = Pengajuan::create([
                'id_periode' => $periode->id_periode,
            ]);

            $pengajuan->user()->attach($request->dosen_ids, [
                'status' => 'diajukan',
                'tanggal_diajukan' => now(),
            ]);

            return redirect()->route('oppt.pengajuanIndex.dosen')->with('success', 'Pengajuan berhasil dibuat!');
            //return response()->json(['Error' => 'jir']);
        } catch (\Throwable $th) {
            $periode = Periode::findOrFail($id);
            // return response()->json(['err' => $th->getMessage(), 'periode' =>$periode ]);
            return redirect()->back()->with('error', $th->getMessage());
        }
    }



    public function ajukanDokumen(Request $request, $id)
    {
        try {
            $request->validate([
                'SPTJM' => 'required|file|mimes:pdf,jpg,jpeg,png',
                'SPPPTS' => 'required|file|mimes:pdf,jpg,jpeg,png',
                'SPKD' => 'required|file|mimes:pdf,jpg,jpeg,png',
            ]);

            $dokumenFiles = [
                'SPTJM' => $request->file('SPTJM'),
                'SPPPTS' => $request->file('SPPPTS'),
                'SPKD' => $request->file('SPKD'),
            ];

            $dokumenNames = ['SPTJM', 'SPPPTS', 'SPKD'];

            $pengajuan = Pengajuan::findOrFail($id);
            foreach ($dokumenFiles as $key => $file) {
                $filePath = $file->store('dokumen', 'public');

                Pengajuan_Dokumen::create([
                    'id_pengajuan' => $pengajuan->id_pengajuan,
                    'nama_dokumen' => $dokumenNames[array_search($key, array_keys($dokumenFiles))],
                    'file_dokumen' => $filePath,
                ]);
            }

            return redirect()->back()->with('success', 'Pengajuan berhasil dibuat dengan dokumen!');
        } catch (\Throwable $th) {
            return response()->json(['Message' => $th]);
        }
    }



    public function updateDokumen($id, Request $request)
{
    try {
        // Validasi input
        $request->validate([
            'SPTJM' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'SPPPTS' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'SPKD' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
        ]);

        // Inisialisasi dokumen yang diupload
        $dokumenFiles = [
            'SPTJM' => $request->file('SPTJM'),
            'SPPPTS' => $request->file('SPPPTS'),
            'SPKD' => $request->file('SPKD'),
        ];

        $dokumenNames = ['SPTJM', 'SPPPTS', 'SPKD'];

        $pengajuan = Pengajuan::findOrFail($id);

        // Loop untuk setiap dokumen yang diupload
        foreach ($dokumenFiles as $key => $file) {
            if ($file) {
                // Cari dokumen lama di database
                $existingDokumen = Pengajuan_Dokumen::where('id_pengajuan', $pengajuan->id_pengajuan)
                    ->where('nama_dokumen', $key)
                    ->first();

                // Hapus file dokumen lama jika ada
                if ($existingDokumen) {
                    Storage::disk('public')->delete($existingDokumen->file_dokumen);

                    // Update dengan file baru
                    $filePath = $file->store('dokumen', 'public');
                    $existingDokumen->update([
                        'file_dokumen' => $filePath,
                    ]);
                } else {
                    // Jika dokumen tidak ada, buat baru
                    $filePath = $file->store('dokumen', 'public');
                    Pengajuan_Dokumen::create([
                        'id_pengajuan' => $pengajuan->id_pengajuan,
                        'nama_dokumen' => $key,
                        'file_dokumen' => $filePath,
                    ]);
                }
            }
        }

        return redirect()->back()->with('success', 'Dokumen berhasil diupdate!');
    } catch (\Throwable $th) {
        return response()->json(['Message' => $th->getMessage()]);
    }
}



    public function showPengajuanSemester($id)
    {
        // Retrieve the pengajuan by its ID
        $pengajuan = Pengajuan::findOrFail($id);

        // Check if there are any shared documents for this pengajuan
        $sharedDocuments = Pengajuan_Dokumen::where('id_pengajuan', $id)
                            ->whereNull('id_user') // Shared documents will not have id_user
                            ->get();

        // Prepare an array to check if each dosen has uploaded documents
        $dosenDocuments = [];
        foreach ($pengajuan->user as $dosen) {
            $dosenDocuments[$dosen->id] = Pengajuan_Dokumen::where('id_pengajuan', $id)
                                    ->where('id_user', $dosen->id)
                                    ->get();
        }
        // dd($sharedDocuments);
        return view('home.tunjangan.pengajuan.ajukan_semester', [
            'pengajuan' => $pengajuan,
            'sharedDocuments' => $sharedDocuments,
            'dosenDocuments' => $dosenDocuments,
        ]);
    }

    // public function showPengajuanSemester($id)
    // {
    //     // Retrieve the pengajuan by its ID
    //     $pengajuan = Pengajuan::findOrFail($id);

    //     // Check if there are any shared documents for this pengajuan
    //     $sharedDocuments = Pengajuan_Dokumen::where('id_pengajuan', $id)
    //                         ->whereNull('id_user') // Shared documents will not have id_user
    //                         ->get();

    //     // Prepare an array to check if each dosen has uploaded documents
    //     $dosenDocuments = [];
    //     foreach ($pengajuan->user as $dosen) {
    //         $dosenDocuments[$dosen->id] = Pengajuan_Dokumen::where('id_pengajuan', $id)
    //                                 ->where('id_user', $dosen->id)
    //                                 ->get();
    //     }
    //     // dd($sharedDocuments);
    //     return view('testing.oppt.show_pengajuan_semester', [
    //         'pengajuan' => $pengajuan,
    //         'sharedDocuments' => $sharedDocuments,
    //         'dosenDocuments' => $dosenDocuments,
    //     ]);
    // }



    public function ajukanDokumenSemester(Request $request)
{
    try {
        $request->validate([
            'id_pengajuan' => 'required|exists:pengajuan,id_pengajuan',
            'shared_sppts' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'shared_spkd' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            // Validation for each dosen
            'sptjm.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'spkk.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
        ]);

        // Handle shared documents
        $sharedFiles = [
            'SP PTS' => $request->file('shared_sppts'),
            'SPKD' => $request->file('shared_spkd'),
        ];

        foreach ($sharedFiles as $key => $file) {
            if ($file) {
                // Store or update logic for shared documents
                $existingDocument = Pengajuan_Dokumen::where('id_pengajuan', $request->input('id_pengajuan'))
                    ->whereNull('id_user') // Shared documents will not have id_user
                    ->where('nama_dokumen', $key)
                    ->first();

                if ($existingDocument) {
                    // Update existing document
                    $filePath = $file->store('dokumen/sharedSemester', 'public');
                    $existingDocument->update(['file_dokumen' => $filePath]);
                } else {
                    // Create new document if it doesn't exist
                    $filePath = $file->store('dokumen/sharedSemester', 'public');
                    Pengajuan_Dokumen::create([
                        'id_pengajuan' => $request->input('id_pengajuan'),
                        'nama_dokumen' => $key,
                        'file_dokumen' => $filePath,
                    ]);
                }
            }
        }

        // Handle documents for each dosen
        foreach ($request->input('dosen_ids', []) as $dosenId) {
            $filePaths = [
                'sptjm_dosen' => $request->file("sptjm.$dosenId"),
                'spkk' => $request->file("spkk.$dosenId"),
            ];

            foreach ($filePaths as $key => $file) {
                if ($file) { // Check if the file was uploaded
                    // Find existing document for dosen
                    $existingDocument = Pengajuan_Dokumen::where('id_pengajuan', $request->input('id_pengajuan'))
                        ->where('id_user', $dosenId)
                        ->where('nama_dokumen', $key)
                        ->first();

                    if ($existingDocument) {
                        // Update existing document
                        $filePath = $file->store('dokumen/dosen/' . $dosenId, 'public');
                        $existingDocument->update(['file_dokumen' => $filePath]);
                    } else {
                        // Create new document if it doesn't exist
                        $filePath = $file->store('dokumen/dosen/' . $dosenId, 'public');
                        Pengajuan_Dokumen::create([
                            'id_pengajuan' => $request->input('id_pengajuan'),
                            'id_user' => $dosenId, // Associate with dosen
                            'nama_dokumen' => $key, // E.g., 'Sptjm'
                            'file_dokumen' => $filePath,
                        ]);
                    }
                }
            }
        }

        return redirect()->route('oppt.pengajuanIndex.dosen')->with('success', 'Dokumen telah dikirim');
    } catch (\Throwable $th) {
        return response()->json(['Message' => $th->getMessage()]);
    }
}


// public function ajukanDokumenSemester(Request $request, $id)
// {
//     try {
//         $request->validate([
//             'SPTJM' => 'required|file|mimes:pdf,jpg,jpeg,png',
//             'SPPPTS' => 'required|file|mimes:pdf,jpg,jpeg,png',
//             'SPKD' => 'required|file|mimes:pdf,jpg,jpeg,png',
//         ]);

//         $dokumenFiles = [
//             'SPTJM' => $request->file('SPTJM'),
//             'SPPPTS' => $request->file('SPPPTS'),
//             'SPKD' => $request->file('SPKD'),
//         ];

//         $dokumenNames = ['SPTJM', 'SPPPTS', 'SPKD'];

//         $pengajuan = Pengajuan::findOrFail($id);
//         foreach ($dokumenFiles as $key => $file) {
//             $filePath = $file->store('dokumen', 'public');

//             Pengajuan_Dokumen::create([
//                 'id_pengajuan' => $pengajuan->id_pengajuan,
//                 'nama_dokumen' => $dokumenNames[array_search($key, array_keys($dokumenFiles))],
//                 'file_dokumen' => $filePath,
//             ]);
//         }

//         return redirect()->back()->with('success', 'Pengajuan berhasil dibuat dengan dokumen!');
//     } catch (\Throwable $th) {
//         return response()->json(['Message' => $th]);
//     }
// }

    public function draftPengajuan($id)
    {
        $pengajuan = Pengajuan::findOrFail($id);
        if ($pengajuan->draft == false) {
            $pengajuan->draft = true;
        }
        $pengajuan->save();
        return redirect()->back();
    }

    // public function editPengajuan($id)
    // {
    //     $oppt = Auth::User();
    //     $pengajuan = Pengajuan::with('user')->findOrFail($id);

    //     $periode = Periode::all();
    //     $oppt = Auth::user();

    //     if($pengajuan->periode->tipe_periode == true){
    //         $id_periode = $pengajuan->periode->id_child;
    //         $dosen = User::where('id_universitas', $oppt->id_universitas)
    //     ->whereHas('bkd', function ($query) use ($id_periode) {

    //         $query->where('kesimpulan_bkd', 'M')
    //             ->where('no_serdos', '!=', 'Belum tersertifikasi dosen')
    //             ->where('id_periode', $id_periode);
    //     })
    //     ->where('status', 'aktif')
    //     ->with(['bkd' => function ($query) use ($id_periode) {

    //         $query->where('id_periode', $id_periode);
    //     }])
    //     ->orderBy('name', 'asc')
    //     ->get();
    //     // return response()->json(['data' => $pengajuan]);
    //     return view('testing.oppt.edit_pengajuan_dosen', ['pengajuan' => $pengajuan, 'periode' => $periode, 'dosen' => $dosen]);
    //     }
    //     else {
    //         $id_periode = $pengajuan->id_periode;
    //         $dosen = User::where('id_universitas', $oppt->id_universitas)
    //     ->whereHas('bkd', function ($query) use ($id_periode) {

    //         $query->where('kesimpulan_bkd', 'M')
    //             ->where('no_serdos', '!=', 'Belum tersertifikasi dosen')
    //             ->where('id_periode', $id_periode);
    //     })
    //     ->where('status', 'aktif')
    //     ->with(['bkd' => function ($query) use ($id_periode) {

    //         $query->where('id_periode', $id_periode);
    //     }])
    //     ->orderBy('name', 'asc')
    //     ->get();
    //     // return response()->json(['data' => $pengajuan]);
    //     return view('testing.oppt.edit_pengajuan_dosen', ['pengajuan' => $pengajuan, 'periode' => $periode, 'dosen' => $dosen]);
    //     }

    // }

    public function editPengajuan($id)
    {
        $oppt = Auth::User();
        $pengajuan = Pengajuan::with('user')->findOrFail($id);

        $periode = Periode::all();
        $oppt = Auth::user();

        if($pengajuan->periode->tipe_periode == true){
            $id_periode = $pengajuan->periode->id_child;
            $dosen = User::where('id_universitas', $oppt->id_universitas)
        ->whereHas('bkd', function ($query) use ($id_periode) {

            $query->where('kesimpulan_bkd', 'M')
                ->where('no_serdos', '!=', 'Belum tersertifikasi dosen')
                ->where('id_periode', $id_periode);
        })
        ->where('status', 'aktif')
        ->with(['bkd' => function ($query) use ($id_periode) {

            $query->where('id_periode', $id_periode);
        }])
        ->orderBy('name', 'asc')
        ->get();
        // return response()->json(['data' => $pengajuan]);
        return view('home.tunjangan.pengajuan.edit_pengajuan', ['pengajuan' => $pengajuan, 'periode' => $periode, 'dosen' => $dosen]);
        }
        else {
            $id_periode = $pengajuan->id_periode;
            $dosen = User::where('id_universitas', $oppt->id_universitas)
        ->whereHas('bkd', function ($query) use ($id_periode) {

            $query->where('kesimpulan_bkd', 'M')
                ->where('no_serdos', '!=', 'Belum tersertifikasi dosen')
                ->where('id_periode', $id_periode);
        })
        ->where('status', 'aktif')
        ->with(['bkd' => function ($query) use ($id_periode) {

            $query->where('id_periode', $id_periode);
        }])
        ->orderBy('name', 'asc')
        ->get();
        // return response()->json(['data' => $pengajuan]);
        return view('home.tunjangan.pengajuan.edit_pengajuan', ['pengajuan' => $pengajuan, 'periode' => $periode, 'dosen' => $dosen]);
        }

    }

    public function updatePengajuan(Request $request, $id)
    {
        try {
            // Validasi request
            $request->validate([
                'id_periode' => 'required|exists:periode,id_periode',
                'dosen_ids' => 'nullable|array',
            ]);

            // Cari pengajuan berdasarkan ID
            $pengajuan = Pengajuan::findOrFail($id);

            // Update pengajuan dengan id_periode baru
            $pengajuan->update([
                'id_periode' => $request->id_periode,
            ]);

            // Sinkronisasi dosen yang diajukan
            $pengajuan->user()->sync($request->dosen_ids, [
                'status' => 'diajukan',
                'tanggal_diajukan' => now(),
            ]);

            // Redirect dengan pesan sukses
            return redirect()->route('oppt.pengajuanIndex.dosen')->with('success', 'Pengajuan berhasil diperbarui!');
        } catch (\Throwable $th) {
            return redirect()->route('oppt.pengajuanIndex.dosen');
        }
    }


    public function deletePengajuan($id){
        try {
            $pengajuan = Pengajuan::findOrFail($id);
            $pengajuan->delete();
            return redirect()->back();
        } catch (\Throwable $th) {
          return response()->json(['error' => $th]);
        }
    }

    public function statusPengajuanDosen($id){
        try {
            $pengajuan = Pengajuan::with('user')->findOrFail($id);
            return view('testing.oppt.index_status_pengajuan_dosen', ['pengajuan' => $pengajuan]);
            //return response()->json(['data' => $pengajuan]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }

    public function createPermohonan(){
        $oppt = Auth::user();
        $dosen = User::all()
        ->where('id_universitas', $oppt->id_universitas);
        return view('testing.oppt.permohonan.create_permohonan', ['dosen'=>$dosen]);
    }
    public function storePermohonan(Request $request){
        $request->validate([
            'permohonan' => 'required|string',
            'id' => 'required|exists:users,id',
        ]);
       Permohonan::create([
        'id' => $request->id,
        'permohonan' => $request->permohonan
        ]);
        return redirect()->back();
    }
    public function indexPermohonan(){
        $oppt = Auth::user();
        $dosenIds = User::where('id_universitas', $oppt->id_universitas)->pluck('id')->toArray();
        $permohonan = Permohonan::with('user')
            ->whereIn('id', $dosenIds)
            ->get();
        $dosen = User::all()
            ->where('id_universitas', $oppt->id_universitas);

        return view('home.verifikasi.dosen.permohonan_verifikasi', ['permohonan'=>$permohonan, 'dosen'=>$dosen]);
    }

    // public function indexPermohonan(){
    //     $oppt = Auth::user();
    //     $dosenIds = User::where('id_universitas', $oppt->id_universitas)->pluck('id')->toArray();
    //     $permohonan = Permohonan::with('user')
    //         ->whereIn('id', $dosenIds)
    //         ->get();
    //     return view('testing.oppt.permohonan.index_permohonan', ['permohonan'=>$permohonan]);
    // }

    public function showPermohonan($id){
        $permohonan = Permohonan::with('user')->findOrFail($id);
        return view('testing.oppt.permohonan.show_permohonan', ['permohonan'=>$permohonan]);
    }

    public function fetchDosen($id){
        try {
            $pengajuan = Pengajuan::findOrFail($id);
            $jumlah = $pengajuan->user()->wherePivot('status', 'diajukan')->count();

            return view('testing.oppt.template', ['pengajuan' => $pengajuan, 'jumlah' => $jumlah]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }

    public function tes(){
        $user = User::with('universitas')->get();
        return response()->json(['user'=> $user]);
        //return view('testing.tesaja.tes_aja', ['user' => $user]);
    }

}
