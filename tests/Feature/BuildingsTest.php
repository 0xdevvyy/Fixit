<?php

use App\Enum\RoleEnum;
use App\Models\Building;
use App\Models\Ticket;
use App\Models\User;

test('buildings show their assigned maintenance staff', function () {
    $admin = User::factory()->create(['role' => RoleEnum::ADMIN]);
    $maintenance = User::factory()->create(['role' => RoleEnum::MAINTENANCE]);
    $building = Building::create([
        'name' => 'Main Building',
        'user_id' => $maintenance->id,
    ]);

    $this->actingAs($admin)
        ->get(route('buildings.index'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('buildings/Index')
            ->where('buildings.0.id', $building->id)
            ->where('buildings.0.maintenance.name', $maintenance->name)
            ->where('buildings.0.maintenance.email', $maintenance->email)
            ->where('canManage', true));
});

test('admins can create and update buildings', function () {
    $admin = User::factory()->create(['role' => RoleEnum::ADMIN]);
    $maintenance = User::factory()->create(['role' => RoleEnum::MAINTENANCE]);
    $anotherMaintenance = User::factory()->create(['role' => RoleEnum::MAINTENANCE]);

    $this->actingAs($admin)
        ->post(route('buildings.store'), [
            'name' => 'Main Building',
            'user_id' => $maintenance->id,
        ])
        ->assertRedirect(route('buildings.index'));

    $building = Building::query()->where('name', 'Main Building')->firstOrFail();

    $this->patch(route('buildings.update', $building), [
        'name' => 'Science Building',
        'user_id' => $anotherMaintenance->id,
    ])->assertRedirect(route('buildings.index'));

    $this->assertDatabaseHas('buildings', [
        'id' => $building->id,
        'name' => 'Science Building',
        'user_id' => $anotherMaintenance->id,
    ]);
});

test('building assignments must be maintenance users', function () {
    $admin = User::factory()->create(['role' => RoleEnum::ADMIN]);
    $teacher = User::factory()->create(['role' => RoleEnum::TEACHER]);

    $this->actingAs($admin)
        ->post(route('buildings.store'), [
            'name' => 'Main Building',
            'user_id' => $teacher->id,
        ])
        ->assertSessionHasErrors('user_id');

    $this->assertDatabaseCount('buildings', 0);
});

test('non-admin users can view but cannot manage buildings', function () {
    $teacher = User::factory()->create(['role' => RoleEnum::TEACHER]);
    $building = Building::create(['name' => 'Main Building']);

    $this->actingAs($teacher)
        ->get(route('buildings.index'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page->where('canManage', false));

    $this->post(route('buildings.store'), ['name' => 'New Building'])
        ->assertForbidden();

    $this->patch(route('buildings.update', $building), ['name' => 'Changed'])
        ->assertForbidden();

    $this->delete(route('buildings.destroy', $building))
        ->assertForbidden();

    $this->assertDatabaseHas('buildings', ['id' => $building->id, 'name' => 'Main Building']);
});

test('admins can delete buildings and their linked tickets', function () {
    $admin = User::factory()->create(['role' => RoleEnum::ADMIN]);
    $reporter = User::factory()->create(['role' => RoleEnum::TEACHER]);
    $building = Building::create(['name' => 'Main Building']);
    $ticket = Ticket::factory()->create([
        'user_id' => $reporter->id,
        'building_id' => $building->id,
    ]);

    $this->actingAs($admin)
        ->delete(route('buildings.destroy', $building))
        ->assertRedirect(route('buildings.index'));

    $this->assertDatabaseMissing('buildings', ['id' => $building->id]);
    $this->assertDatabaseMissing('tickets', ['id' => $ticket->id]);
});
