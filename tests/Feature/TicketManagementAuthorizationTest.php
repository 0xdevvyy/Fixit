<?php

use App\Enum\RoleEnum;
use App\Models\Building;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

test('ticket owners and assignees can edit and delete but admins and other users cannot', function () {
    $reporter = User::factory()->create(['role' => RoleEnum::TEACHER]);
    $assignee = User::factory()->create(['role' => RoleEnum::MAINTENANCE]);
    $admin = User::factory()->create(['role' => RoleEnum::ADMIN]);
    $otherUser = User::factory()->create(['role' => RoleEnum::TEACHER]);
    $ticket = Ticket::factory()->create([
        'user_id' => $reporter->id,
        'assigned_to' => $assignee->id,
        'building_id' => Building::factory()->create()->id,
    ]);

    foreach ([$reporter, $assignee] as $user) {
        expect(Gate::forUser($user)->allows('edit', $ticket))->toBeTrue()
            ->and(Gate::forUser($user)->allows('update', $ticket))->toBeTrue()
            ->and(Gate::forUser($user)->allows('delete', $ticket))->toBeTrue();
    }

    expect(Gate::forUser($admin)->allows('view', $ticket))->toBeTrue()
        ->and(Gate::forUser($admin)->allows('edit', $ticket))->toBeFalse()
        ->and(Gate::forUser($admin)->allows('update', $ticket))->toBeFalse()
        ->and(Gate::forUser($admin)->allows('delete', $ticket))->toBeFalse()
        ->and(Gate::forUser($otherUser)->allows('edit', $ticket))->toBeFalse()
        ->and(Gate::forUser($otherUser)->allows('delete', $ticket))->toBeFalse();
});
