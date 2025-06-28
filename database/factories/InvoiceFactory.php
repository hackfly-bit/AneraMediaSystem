<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $amount = fake()->numberBetween(5000000, 100000000); // 5M to 100M IDR
        $taxAmount = $amount * 0.11; // 11% tax
        $totalAmount = $amount + $taxAmount;
        
        return [
            'client_id' => Client::factory(),
            'project_id' => Project::factory(),
            'invoice_number' => 'INV-' . fake()->unique()->numerify('####'),
            'amount' => $amount,
            'tax_amount' => $taxAmount,
            'total_amount' => $totalAmount,
            'status' => fake()->randomElement(['pending', 'paid', 'overdue']),
            'issue_date' => fake()->dateTimeBetween('-3 months', 'now'),
            'due_date' => fake()->dateTimeBetween('now', '+2 months'),
            'paid_date' => null,
            'notes' => fake()->optional()->paragraph(),
            'payment_percentage' => fake()->randomElement([25, 50, 75, 100]),
            'payment_sequence' => fake()->numberBetween(1, 4),
            'currency' => 'IDR',
        ];
    }
    
    /**
     * Indicate that the invoice is paid.
     */
    public function paid(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'paid',
            'paid_date' => fake()->dateTimeBetween($attributes['issue_date'], 'now'),
        ]);
    }
    
    /**
     * Indicate that the invoice is overdue.
     */
    public function overdue(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'overdue',
            'due_date' => fake()->dateTimeBetween('-1 month', '-1 day'),
        ]);
    }
}