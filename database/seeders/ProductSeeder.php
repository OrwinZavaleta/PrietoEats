<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Productos Básicos
        DB::table('products')->insert([
            ['id' => 1, 'name' => 'Pastel', 'description' => 'Es un pastel clásico', 'price' => 2.00, 'image' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Pastel de patata', 'description' => 'Es un pastel con patatas y carne', 'price' => 5.00, 'image' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'Pavlova de Frutos Rojos', 'description' => 'Merengue crujiente con crema y frutos rojos', 'price' => 4.50, 'image' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'name' => 'Solomillo de Cerdo Stroganoff', 'description' => 'Solomillo en salsa cremosa con champiñones', 'price' => 8.50, 'image' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'name' => 'Albondigas de Pollo', 'description' => 'Albóndigas caseras en salsa de tomate', 'price' => 6.00, 'image' => 'img/albondigasPollo.png', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'name' => 'Ensalada de Patata', 'description' => 'Patata cocida, huevo, atún y mayonesa', 'price' => 3.50, 'image' => 'img/ensaladaPatata.png', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 7, 'name' => 'Flan Parisien', 'description' => 'Tarta de flan cremosa sobre base de hojaldre', 'price' => 3.00, 'image' => 'img/flanParisien.png', 'created_at' => now(), 'updated_at' => now()],
            
            // Nuevos Productos
            ['id' => 8, 'name' => 'Lasaña de Carne', 'description' => 'Lasaña tradicional con bechamel gratinada', 'price' => 7.50, 'image' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 9, 'name' => 'Sopa de Marisco', 'description' => 'Sopa reconfortante con gambas y almejas', 'price' => 6.50, 'image' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 10, 'name' => 'Tarta de Queso', 'description' => 'Tarta de queso estilo New York', 'price' => 4.00, 'image' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 11, 'name' => 'Pollo al Curry', 'description' => 'Pollo tierno en salsa de curry suave con arroz', 'price' => 7.00, 'image' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 12, 'name' => 'Croquetas de Jamón', 'description' => 'Ración de 6 croquetas caseras', 'price' => 5.50, 'image' => NULL, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Ajustar secuencia si es PostgreSQL
        // DB::statement("SELECT setval('products_id_seq', (SELECT MAX(id) FROM products));"); 
    }
}