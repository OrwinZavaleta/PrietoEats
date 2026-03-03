<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class OfferSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // Ofertas Pasadas
        DB::table('offers')->insert([
            ['id' => 1, 'date_delivery' => $now->copy()->subWeeks(2)->format('Y-m-d'), 'time_delivery' => '13:00 a 14:00', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'date_delivery' => $now->copy()->subWeek()->format('Y-m-d'), 'time_delivery' => '13:00 a 14:00', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Oferta Actual/Cercana
        DB::table('offers')->insert([
            ['id' => 3, 'date_delivery' => $now->copy()->addDays(2)->format('Y-m-d'), 'time_delivery' => '12:30 a 13:30', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'date_delivery' => $now->copy()->addDays(5)->format('Y-m-d'), 'time_delivery' => '14:00 a 15:00', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Ofertas Futuras
        DB::table('offers')->insert([
            ['id' => 5, 'date_delivery' => $now->copy()->addWeeks(2)->format('Y-m-d'), 'time_delivery' => '13:00 a 14:00', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'date_delivery' => $now->copy()->addWeeks(3)->format('Y-m-d'), 'time_delivery' => '13:00 a 14:00', 'created_at' => now(), 'updated_at' => now()],
        ]);

         // DB::statement("SELECT setval('offers_id_seq', (SELECT MAX(id) FROM offers));");
    }
}