<?php

namespace Database\Factories;

use App\Models\Ticket;
use App\Models\TicketLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TicketLog>
 */
class TicketLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::pluck('id')->random(),

            'ticket_id' => Ticket::pluck('id')->random(),
            'action' => fake()->randomElement(['create', 'update', 'edit', 'delete']),
            'old_value' => ['title' => 'ticket example', 'description' => fake()->sentence()], //this should be the value of the ticket but for now i will just add 2 values
            'new_value' => ['title' => 'ticket example', 'description' => fake()->sentence()],
        ];
    }
}
