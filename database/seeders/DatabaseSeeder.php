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
            'role_id' => 1,
        ]);

        FinancialProduct::create([
            'name' => 'Crédito Personal',
            'description' => 'Préstamo destinado a personas naturales para gastos personales o familiares.',
            'interest_rate' => 12.5,
            'max_term_months' => 24,
            'min_amount' => 1000,
            'max_amount' => 20000,
            'status' => 'active',
        ]);

        FinancialProduct::create([
            'name' => 'Crédito Empresarial',
            'description' => 'Financiamiento para capital de trabajo o inversión en negocios.',
            'interest_rate' => 10.0,
            'max_term_months' => 36,
            'min_amount' => 5000,
            'max_amount' => 50000,
            'status' => 'active',
        ]);

        FinancialProduct::create([
            'name' => 'Crédito Hipotecario',
            'description' => 'Crédito para la adquisición, construcción o mejora de vivienda.',
            'interest_rate' => 8.5,
            'max_term_months' => 240,
            'min_amount' => 20000,
            'max_amount' => 500000,
            'status' => 'active',
        ]);

        // Creamos datos falsos de otras tablas
        // User::factory(1)->create();
        // Client::factory(5)->create();
        // FinancialProduct::factory(3)->create();
        // Credit::factory(15)->create();
        // Payment::factory(20)->create();
    }
}
