<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Credit;
use App\Models\FinancialProduct;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Credit>
 */
class CreditFactory extends Factory
{

    protected $model = Credit::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'amount' => fake()->randomFloat(2),
            'interest_rate' => fake()->randomFloat(5, 0, 20),
            'term_months' => fake()->numberBetween(0, 24),
            'start_date' => fake()->dateTime(),
            'end_date' => fake()->dateTime(),
            'status' => fake()->randomElement(['pending', 'approved', 'rejected', 'paid']),
            'paid_balance' => fake()->randomFloat(2),
            'product_id' => FinancialProduct::query()->inRandomOrder()->value('id') ?? FinancialProduct::factory(),
            'client_id' => Client::query()->inRandomOrder()->value('id') ?? Client::factory(),
            'approved_by' => User::query()->inRandomOrder()->value('id') ?? User::factory(),
        ];
    }
}
