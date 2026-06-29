<?php

namespace Database\Factories;

use App\Models\Ticket;
use App\Models\TicketAttachment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TicketAttachment>
 */
class TicketAttachmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ticket_id' => Ticket::pluck('id')->random(),
            'user_id' => User::pluck('id')->random(),
            'image_status' => fake()->randomElement(['before', 'after']),
            'image_path' =>fake()->imageUrl(),
        ];
    }
}
