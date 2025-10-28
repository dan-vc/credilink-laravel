<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Credit;
use App\Models\FinancialProduct;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        // Ejecutar Seeder Roles
        $this->call([
            RoleSeeder::class,
        ]);

        // Crear usuario admin
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@credilink.com',
            'role_id' => 1
        ]);

        // Creamos datos falsos de otras tablas
        User::factory(1)->create();
        Client::factory(5)->create();
        FinancialProduct::factory(3)->create();
        Credit::factory(15)->create();
        Payment::factory(20)->create();
    }
}
