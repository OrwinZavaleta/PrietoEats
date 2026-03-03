<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Usuarios
        // Admin
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'is_admin' => true, 
        ]);
        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@mail.com',
            'password' => Hash::make('12345678'),
            'is_admin' => true, 
        ]);

        // Usuario normal de prueba
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@mail.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
        ]);

        // Crear 10 usuarios extra aleatorios
        User::factory(10)->create();

        // 2. Productos, Ofertas y Vinculación
        $this->call([
            ProductSeeder::class,
            OfferSeeder::class,
            OfferProductSeeder::class,
            OrderSeeder::class, // Nuevo seeder de órdenes
        ]);
    }
}