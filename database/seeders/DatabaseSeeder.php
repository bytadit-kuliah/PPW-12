<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $this->call([
            BarangSeeder::class
        ]);

        Kategori::create(
            ['nama' => 'Mudah Pecah']
        );
        Kategori::create(
            ['nama' => 'Mudah Sobek']
        );
        Kategori::create(
            ['nama' => 'Mudah Nangis']
        );
    }
}
