<?php

namespace Database\Seeders;

use App\Models\Anggota;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class AnggotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();  // Inisialisasi Faker

        // Generate data dummy untuk 10 anggota
        foreach (range(1, 10) as $index) {
            Anggota::create([
                'id' => Str::uuid(), // Gunakan UUID untuk ID
                'nama' => $faker->name(),  // Nama anggota
                'email' => $faker->unique()->safeEmail(), // Email unik
                'no_hp' => $faker->phoneNumber(),  // Nomor HP
                'alamat' => $faker->address(),  // Alamat anggota
                'tanggal_daftar' => $faker->date(),  // Tanggal pendaftaran
                'status_anggota' => $faker->randomElement(['active', 'inactive']), // Status aktif/tidak aktif
            ]);
        }
    }
}
