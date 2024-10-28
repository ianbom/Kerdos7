<?php

namespace Database\Seeders;

use App\Models\Informasi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InformasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Informasi::insert([
            [
                'judul' => 'Ajukan Informasi',
                'deskripsi' => 'Pengajuan anda ditunda',
                'image_informasi' => '/images/WhatsApp Image 2024-10-16 at 11.28.37_27dfa354.jpg',
            ],
            [
                'judul' => 'Informasi Terkini',
                'deskripsi' => 'Pembaharuan informasi terbaru akan diumumkan minggu depan',
                'image_informasi' => '/images/WhatsApp Image 2024-10-16 at 11.28.37_8685e8ff.jpg',
            ],
            [
                'judul' => 'Laporan Mingguan',
                'deskripsi' => 'Laporan mingguan telah diterbitkan',
                'image_informasi' => '/images/WhatsApp Image 2024-10-16 at 11.28.38_04ec29f2.jpg',
            ],
            [
                'judul' => 'Pengingat Penting',
                'deskripsi' => 'Harap ingat untuk menyelesaikan tugas sebelum tenggat waktu',
                'image_informasi' => 'https://loremflickr.com/320/240',
            ],
            [
                'judul' => 'Acara Mendatang',
                'deskripsi' => 'Jangan lupa untuk menghadiri acara tahunan kami',
                'image_informasi' => 'https://loremflickr.com/320/240',
            ],
            [
                'judul' => 'Pembaharuan Sistem',
                'deskripsi' => 'Sistem akan menjalani pemeliharaan pada hari Sabtu',
                'image_informasi' => 'https://loremflickr.com/320/240',
            ],
            [
                'judul' => 'Ajukan Informasi',
                'deskripsi' => 'Pengajuan anda ditunda',
                'image_informasi' => 'https://loremflickr.com/320/240',
            ],
            [
                'judul' => 'Ajukan Data',
                'deskripsi' => 'Pengajuan anda diterima',
                'image_informasi' => 'https://loremflickr.com/320/240',
            ],
            [
                'judul' => 'Konfirmasi Data',
                'deskripsi' => 'Pengajuan anda masih dalam proses',
                'image_informasi' => 'https://loremflickr.com/320/240',
            ],
        ]);

    }
}
