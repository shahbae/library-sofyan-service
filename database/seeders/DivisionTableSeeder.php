<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use App\Models\Division;

class DivisionTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();  // Inisialisasi Faker
        
        // Generate data dummy untuk 10 anggota
        foreach (range(1, 10) as $index) {
            Division::create([
                'id' => Str::uuid(), // Gunakan UUID untuk ID
                'name_divisi' => $faker->name(),  // Nama anggota
                'name_pic' => $faker->name(),  // Nama anggota
            ]);
        }
    }
}
