<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class TemplateController extends Controller
{

    public function showFormSuratKeaslianDokumen()
    {
        return view('testing.template.surat_pernyataan_kebenaran_dokumen_form');
    }

    public function generatePDFSuratKeaslianDokumen(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'nama' => 'required|string',
            'jabatan' => 'required|string',
            'namaPTS' => 'required|string',
            'alamatPTS' => 'required|string',
            'nomor' => 'required|string',
            'tanggal' => 'required|string',
            'headerImage' => 'required|image',
            'footerImage' => 'required|image',
        ]);

        // Convert uploaded images to base64
        $headerImage = base64_encode(file_get_contents($request->file('headerImage')->path()));
        $footerImage = base64_encode(file_get_contents($request->file('footerImage')->path()));

        // Gather all form inputs and image data
        $data = [
            'headerImage' => $headerImage,
            'footerImage' => $footerImage,
            'title' => $request->input('title'),
            'nama' => $request->input('nama'),
            'jabatan' => $request->input('jabatan'),
            'namaPTS' => $request->input('namaPTS'),
            'alamatPTS' => $request->input('alamatPTS'),
            'nomor' => $request->input('nomor'),
            'tanggal' => $request->input('tanggal'),
        ];

        // Load view with data and generate PDF
        $pdf = Pdf::loadView('testing.template.surat_pernyataan_kebenaran_dokumen', $data);
        return $pdf->download('surat pernyataan kebenaran dan keaslian dokumen.pdf');
    }

}