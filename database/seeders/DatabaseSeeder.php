<?php

namespace Database\Seeders;

use App\Models\Venue;
use App\Models\Kursi;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat venue (jika belum ada)
        $venue = Venue::first();
        if (!$venue) {
            $venue = Venue::create([
                'nama_venue' => 'Stadion Utama',
                'alamat'     => 'Jakarta',
                'kapasitas'  => 100,
            ]);
        }

        // 2. Generate kursi untuk venue ini (hanya jika belum ada kursi)
        if ($venue->kursis()->count() == 0) {
            $rows = ['A', 'B', 'C', 'D', 'E'];
            $seatsPerRow = 20; // 5 baris x 20 = 100 kursi
            for ($i = 0; $i < count($rows); $i++) {
                for ($j = 1; $j <= $seatsPerRow; $j++) {
                    Kursi::create([
                        'id_venue'   => $venue->id_venue,
                        'nomor_kursi' => $rows[$i] . $j,
                        'baris'      => $rows[$i],
                        'tipe_kursi' => ($i < 2) ? 'vip' : 'reguler',
                        'status'     => 'available',
                    ]);
                }
            }
        }

        // 3. Buat user admin (jika belum ada)
        User::firstOrCreate(
            ['email' => 'admin@tiketkonser.com'],
            [
                'name'     => 'Administrator',
                'password' => Hash::make('password'),
                'is_admin' => true,
            ]
        );
    }
}