<?php

namespace Database\Factories;

use App\Models\Credit;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'amount' => fake()->randomFloat(2),
            'payment_type' => fake()->randomElement(['efectivo', 'transferencia', 'tarjeta']),
            'payment_note' => fake()->sentence(5),
            'status' => fake()->randomElement(['pago realizado', 'no pagado', 'atrasado']),
            'extra_payment' => fake()->randomFloat(2),
            'total' => fake()->randomFloat(2),
            'start_date' => fake()->dateTimeThisYear(),
            'due_date' => fake()->dateTimeThisYear(),
            'paid_date' => fake()->dateTimeThisYear(),
            'credit_id' => Credit::query()->inRandomOrder()->value('id') ?? Credit::factory(),
            'processed_by' => User::query()->inRandomOrder()->value('id') ?? User::factory(),
        ];
    }
}
