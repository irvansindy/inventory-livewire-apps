<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class OfficeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('offices')->insert([
            [
                'officeName' => 'Head Office',
                'officeAddress' => 'Alam Sutera, Synergy, Jl. Jalur Sutera Bar. No.17, RT.002/RW.003, East Panunggangan, Pinang, Tangerang City, Banten 15143',
            ],
            [
                'officeName' => 'Cimanggis Office',
                'officeAddress' => 'Jl. Raya Jakarta-Bogor No.1, RW.6, Curug, Kec. Cimanggis, Kota Depok, Jawa Barat 16416',
            ],
            [
                'officeName' => 'Karawang Office',
                'officeAddress' => 'Dusun Gintung Kebon RT. 12 & 13, Karawang, Gintungkerta, Kec. Klari, Karawang, Jawa Barat 41371',
            ],
            [
                'officeName' => 'Gudang Serpong Office',
                'officeAddress' => 'Pakulonan, Kec. Serpong Utara, Kota Tangerang Selatan, Banten 15325',
            ],
        ]);
    }
}
