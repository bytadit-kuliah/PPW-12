<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Barang;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Barang::create([
        //     'nama' => 'gelas',
        //     'stok' => 10,
        // ]);

        Barang::firstOrCreate(
            ['nama' => 'buku'],
            ['stok' => 5]
        );

        Barang::firstOrCreate(
            ['nama' => 'gelas'],
            ['stok' => 10]
        );
    }
}
