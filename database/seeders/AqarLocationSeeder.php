<?php

namespace Database\Seeders;

use App\Models\aqar;
use App\Models\AqarLocation;
use Illuminate\Database\Seeder;

/**
 * Seeds the aqar_locations table with coordinates for existing properties.
 *
 * Uses approximate coordinates for Egyptian governorates.
 * Run: php artisan db:seed --class=AqarLocationSeeder
 */
class AqarLocationSeeder extends Seeder
{
    /**
     * Approximate center coordinates for common Egyptian governorates.
     */
    private array $governorateCoords = [
        // Cairo area
        1  => ['lat' => 30.0444, 'lon' => 31.2357, 'spread' => 0.05],
        // Giza
        2  => ['lat' => 30.0131, 'lon' => 31.2089, 'spread' => 0.04],
        // Alexandria
        3  => ['lat' => 31.2001, 'lon' => 29.9187, 'spread' => 0.04],
        // Qalyubia
        4  => ['lat' => 30.3292, 'lon' => 31.2422, 'spread' => 0.04],
        // Sharqia
        5  => ['lat' => 30.5852, 'lon' => 31.5020, 'spread' => 0.06],
        // Dakahlia
        6  => ['lat' => 31.0364, 'lon' => 31.3807, 'spread' => 0.05],
        // Monufia
        7  => ['lat' => 30.5972, 'lon' => 30.9876, 'spread' => 0.04],
        // Gharbia
        8  => ['lat' => 30.8754, 'lon' => 31.0295, 'spread' => 0.04],
        // Kafr El Sheikh
        9  => ['lat' => 31.1107, 'lon' => 30.9388, 'spread' => 0.04],
        // Beheira
        10 => ['lat' => 30.8481, 'lon' => 30.3436, 'spread' => 0.05],
        // Port Said
        11 => ['lat' => 31.2653, 'lon' => 32.3019, 'spread' => 0.02],
        // Suez
        12 => ['lat' => 29.9668, 'lon' => 32.5498, 'spread' => 0.02],
        // Ismailia
        13 => ['lat' => 30.5965, 'lon' => 32.2715, 'spread' => 0.03],
        // Damietta
        14 => ['lat' => 31.4175, 'lon' => 31.8144, 'spread' => 0.03],
        // Faiyum
        15 => ['lat' => 29.3084, 'lon' => 30.8428, 'spread' => 0.04],
        // Beni Suef
        16 => ['lat' => 29.0661, 'lon' => 31.0994, 'spread' => 0.04],
        // Minya
        17 => ['lat' => 28.0871, 'lon' => 30.7618, 'spread' => 0.05],
        // Asyut
        18 => ['lat' => 27.1783, 'lon' => 31.1859, 'spread' => 0.05],
        // Sohag
        19 => ['lat' => 26.5591, 'lon' => 31.6948, 'spread' => 0.05],
        // Qena
        20 => ['lat' => 26.1551, 'lon' => 32.7160, 'spread' => 0.04],
        // Luxor
        21 => ['lat' => 25.6872, 'lon' => 32.6396, 'spread' => 0.03],
        // Aswan
        22 => ['lat' => 24.0889, 'lon' => 32.8998, 'spread' => 0.04],
        // Red Sea
        23 => ['lat' => 27.2579, 'lon' => 33.8116, 'spread' => 0.08],
        // New Valley
        24 => ['lat' => 25.4390, 'lon' => 30.5586, 'spread' => 0.10],
        // Matrouh
        25 => ['lat' => 31.3525, 'lon' => 27.2453, 'spread' => 0.06],
        // North Sinai
        26 => ['lat' => 31.0602, 'lon' => 33.8355, 'spread' => 0.06],
        // South Sinai
        27 => ['lat' => 28.2358, 'lon' => 33.9785, 'spread' => 0.06],
    ];

    public function run()
    {
        $aqars = aqar::where('status', 1)
            ->whereNotNull('governrate_id')
            ->doesntHave('aqarLocation')
            ->get();

        $count = 0;

        foreach ($aqars as $aqar) {
            $govId = $aqar->governrate_id;
            $coords = $this->governorateCoords[$govId] ?? null;

            if (!$coords) {
                // Default to Cairo with wider spread
                $coords = ['lat' => 30.0444, 'lon' => 31.2357, 'spread' => 0.08];
            }

            // Add some random offset so markers don't overlap
            $lat = $coords['lat'] + (mt_rand(-100, 100) / 100) * $coords['spread'];
            $lon = $coords['lon'] + (mt_rand(-100, 100) / 100) * $coords['spread'];

            AqarLocation::create([
                'id_aqar' => $aqar->id,
                'lat'     => round($lat, 8),
                'lon'     => round($lon, 8),
            ]);

            $count++;
        }

        $this->command->info("Created {$count} aqar_locations records.");
    }
}
