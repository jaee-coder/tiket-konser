<?php

namespace App\Console\Commands;

use App\Models\Venue;
use App\Models\Kursi;
use Illuminate\Console\Command;

class GenerateSeatsCommand extends Command
{
    protected $signature = 'seats:generate {venue_id} {--rows=A,B,C} {--seats_per_row=10}';
    protected $description = 'Generate kursi untuk venue tertentu';

    public function handle()
    {
        $venueId = $this->argument('venue_id');
        $rows = explode(',', $this->option('rows'));
        $seatsPerRow = (int)$this->option('seats_per_row');

        $venue = Venue::find($venueId);
        if (!$venue) {
            $this->error("Venue dengan ID $venueId tidak ditemukan!");
            return 1;
        }

        $created = 0;
        foreach ($rows as $row) {
            for ($i = 1; $i <= $seatsPerRow; $i++) {
                $seatNumber = $row . $i;
                Kursi::updateOrCreate(
                    [
                        'id_venue'    => $venueId,
                        'nomor_kursi' => $seatNumber,
                    ],
                    [
                        'baris'      => $row,
                        'tipe_kursi' => ($row == 'A' || $row == 'B') ? 'vip' : 'reguler',
                        'status'     => 'available',
                    ]
                );
                $created++;
            }
        }

        $this->info("Berhasil generate $created kursi untuk venue '{$venue->nama_venue}'.");
        return 0;
    }
}