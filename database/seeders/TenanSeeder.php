<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TenanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tenans')->truncate();
        DB::table('tenans')->insert([
            [
                'kode_tenan'   => '00001',
                'nama_tenan'   => 'Bu Oneng',
                'telp'         => '0812321313'
            ],
            [
                'kode_tenan'   => '00002',
                'nama_tenan'   => 'Kantin Jaya Makmur',
                'telp'         => '081235512'
            ],
            [
                'kode_tenan'   => '00003',
                'nama_tenan'   => 'Warung Berkah',
                'telp'         => '0898233434'
            ],
        ]);
    }
}
