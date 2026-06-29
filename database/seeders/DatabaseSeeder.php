<?php

namespace Database\Seeders;

use App\Models\Building;
use App\Models\Ticket;
use App\Models\TicketAttachment;
use App\Models\TicketLog;
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

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        User::factory()->count(10)->create();

        // 2. Buildings
        Building::factory()->count(5)->create();

        // 3. Tickets
        Ticket::factory()->count(50)->create();

        // 4. Ticket Logs
        TicketLog::factory()->count(100)->create();

        // 5. Ticket Attachments
        TicketAttachment::factory()->count(50)->create();
    }
}
