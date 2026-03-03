<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class OfferProductSeeder extends Seeder
{
    public function run(): void
    {
        // Oferta 1 (Pasada): Menú Clásico
        DB::table('product_offers')->insert([
            ['offer_id' => 1, 'product_id' => 1, 'created_at' => now(), 'updated_at' => now()], // Pastel
            ['offer_id' => 1, 'product_id' => 2, 'created_at' => now(), 'updated_at' => now()], // Pastel de patata
            ['offer_id' => 1, 'product_id' => 6, 'created_at' => now(), 'updated_at' => now()], // Ensalada
        ]);

        // Oferta 2 (Pasada): Menú Internacional
        DB::table('product_offers')->insert([
            ['offer_id' => 2, 'product_id' => 4, 'created_at' => now(), 'updated_at' => now()], // Stroganoff
            ['offer_id' => 2, 'product_id' => 11, 'created_at' => now(), 'updated_at' => now()], // Curry
            ['offer_id' => 2, 'product_id' => 3, 'created_at' => now(), 'updated_at' => now()], // Pavlova
        ]);

        // Oferta 3 (Próxima): Menú Reconfortante
        DB::table('product_offers')->insert([
            ['offer_id' => 3, 'product_id' => 8, 'created_at' => now(), 'updated_at' => now()], // Lasaña
            ['offer_id' => 3, 'product_id' => 5, 'created_at' => now(), 'updated_at' => now()], // Albóndigas
            ['offer_id' => 3, 'product_id' => 10, 'created_at' => now(), 'updated_at' => now()], // Tarta de Queso
        ]);

        // Oferta 4 (Futura): Tapeo
        DB::table('product_offers')->insert([
            ['offer_id' => 4, 'product_id' => 12, 'created_at' => now(), 'updated_at' => now()], // Croquetas
            ['offer_id' => 4, 'product_id' => 7, 'created_at' => now(), 'updated_at' => now()], // Flan
            ['offer_id' => 4, 'product_id' => 6, 'created_at' => now(), 'updated_at' => now()], // Ensalada
        ]);

        // Oferta 5 (Futura): Mar y Montaña
        DB::table('product_offers')->insert([
            ['offer_id' => 5, 'product_id' => 9, 'created_at' => now(), 'updated_at' => now()], // Sopa Marisco
            ['offer_id' => 5, 'product_id' => 2, 'created_at' => now(), 'updated_at' => now()], // Pastel patata
        ]);
        
        // DB::statement("SELECT setval('product_offers_id_seq', (SELECT MAX(id) FROM product_offers));");
    }
}