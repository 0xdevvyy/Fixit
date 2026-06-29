<?php

namespace Database\Factories;

use App\Enum\TicketCategory;
use App\Enum\TicketPriority;
use App\Enum\TicketStatus;
use App\Models\Building;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Ticket>
 */
class TicketFactory extends Factory
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
            'assigned_to' => fake()->boolean(70)
                ? User::pluck('id')->random()
                : null,
            'building_id' =>  Building::pluck('id')->random(),  //Building::query()->inRandomOrder()->value('id')
            'ticket_number' => fake()->unique()->numerify('T-##C##D#'),
            'title' => fake()->title(),
            'room' => fake()->word(),
            'category' => fake()->randomElement(TicketCategory::cases()),
            'description' => fake()->sentence(),
            'priority' => fake()->randomElement(TicketPriority::cases()),
            'status' => fake()->randomElement(TicketStatus::cases()),
            'assigned_at' => fake()->dateTime(),
            'accepted_at' => fake()->dateTime(),
            'completed_at' => fake()->dateTime(),
            'closed_at' => fake()->dateTime(),
        ];
    }
}
