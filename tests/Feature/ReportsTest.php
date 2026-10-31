<?php

use App\Enum\RoleEnum;
use App\Enum\TicketStatus;
use App\Models\Building;
use App\Models\Ticket;
use App\Models\User;
use App\Queries\Ticket\ReportTicketsQuery;
use Carbon\Carbon;

test('reports are limited to the selected period and the current role scope', function () {
    $teacher = User::factory()->create(['role' => RoleEnum::TEACHER]);
    $anotherTeacher = User::factory()->create(['role' => RoleEnum::TEACHER]);
    $maintenance = User::factory()->create(['role' => RoleEnum::MAINTENANCE]);
    $anotherMaintenance = User::factory()->create(['role' => RoleEnum::MAINTENANCE]);
    $admin = User::factory()->create(['role' => RoleEnum::ADMIN]);
    $building = Building::factory()->create();

    Ticket::factory()->create([
        'user_id' => $teacher->id,
        'assigned_to' => $maintenance->id,
        'building_id' => $building->id,
        'status' => TicketStatus::OPEN,
        'created_at' => Carbon::parse('2026-10-08 12:00:00'),
    ]);
    Ticket::factory()->create([
        'user_id' => $anotherTeacher->id,
        'assigned_to' => $maintenance->id,
        'building_id' => $building->id,
        'status' => TicketStatus::CLOSED,
        'created_at' => Carbon::parse('2026-10-12 12:00:00'),
    ]);
    Ticket::factory()->create([
        'user_id' => $teacher->id,
        'assigned_to' => $anotherMaintenance->id,
        'building_id' => $building->id,
        'status' => TicketStatus::COMPLETED,
        'created_at' => Carbon::parse('2026-10-15 12:00:00'),
    ]);
    Ticket::factory()->create([
        'user_id' => $teacher->id,
        'assigned_to' => $maintenance->id,
        'building_id' => $building->id,
        'status' => TicketStatus::ASSIGNED,
        'created_at' => Carbon::parse('2026-11-01 12:00:00'),
    ]);

    $query = app(ReportTicketsQuery::class);
    $start = Carbon::parse('2026-10-01')->startOfDay();
    $end = Carbon::parse('2026-10-31')->endOfDay();

    expect($query->execute($admin, $start, $end)['total'])->toBe(3)
        ->and($query->execute($teacher, $start, $end)['total'])->toBe(2)
        ->and($query->execute($maintenance, $start, $end)['total'])->toBe(2)
        ->and($query->execute($admin, $start, $end)['statuses']['open'])->toBe(1);
});
