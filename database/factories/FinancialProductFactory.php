<?php

namespace Database\Factories;

use App\Models\FinancialProduct;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FinancialProduct>
 */
class FinancialProductFactory extends Factory
{
    protected $model = FinancialProduct::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->word(),
            'description' => fake()->sentence(6),
            'interest_rate' => fake()->randomFloat(2, 0, 20),
            'max_term_months' => fake()->numberBetween(6, 24),
            'min_amount' => fake()->randomFloat(2, 0, 1000),
            'max_amount' => fake()->randomFloat(2, 1100, 10000),
            'status' => fake()->randomElement(['active', 'inactive']),
        ];
    }
}
