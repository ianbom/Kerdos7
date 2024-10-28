<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PeriodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nama_periode' => ' Semester November 2024',
                'tipe_periode' => 1,
                'masa_periode_awal' => Carbon::createFromFormat('Y-m-d', '2024-01-01'),
                'masa_periode_berakhir' => Carbon::createFromFormat('Y-m-d', '2024-06-30'),
                'id_child' => null,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_periode' => 'Bulanan Oktober 2024',
                'tipe_periode' => 0,
                'masa_periode_awal' => Carbon::createFromFormat('Y-m-d', '2024-07-01'),
                'masa_periode_berakhir' => Carbon::createFromFormat('Y-m-d', '2024-12-31'),
                'id_child' => 1,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insert data ke tabel periode
        DB::table('periode')->insert($data);
    }
}