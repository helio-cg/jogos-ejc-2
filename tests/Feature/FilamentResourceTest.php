<?php

use App\Models\User;
use App\Models\Atleta;
use App\Models\Paroquia;

test('user can view atletas in their parish', function () {
    $paroquia = Paroquia::create(['name' => 'São José', 'city' => 'Fortaleza']);
    $user = User::factory()->create([
        'active' => true,
        'password' => bcrypt('password'),
        'paroquia_id' => $paroquia->id,
    ]);

    $sameParishUser = User::factory()->create([
        'paroquia_id' => $paroquia->id,
    ]);
    $differentParishUser = User::factory()->create();

    Atleta::create([
        'nome' => 'Same Parish Atleta',
        'user_id' => $sameParishUser->id,
        'modalidade' => ['Futsal'],
    ]);
    Atleta::create([
        'nome' => 'Different Parish Atleta',
        'user_id' => $differentParishUser->id,
        'modalidade' => ['Volei'],
    ]);

    $this->actingAs($user, 'web');

    $response = $this->get('/user/atletas');

    $response->assertStatus(200);
});

test('parent sub users are scoped to parent', function () {
    $parent1 = User::factory()->create([
        'role' => 'parent',
        'active' => true,
        'password' => bcrypt('password'),
    ]);
    $parent2 = User::factory()->create([
        'role' => 'parent',
        'active' => true,
    ]);

    $child1 = User::factory()->create([
        'role' => 'sub_user',
        'parent_id' => $parent1->id,
    ]);
    $child2 = User::factory()->create([
        'role' => 'sub_user',
        'parent_id' => $parent2->id,
    ]);

    $this->actingAs($parent1, 'web');

    $response = $this->get('/user/sub-users');

    $response->assertStatus(200);
});

test('atleta creation via direct model', function () {
    $user = User::factory()->create([
        'active' => true,
        'password' => bcrypt('password'),
    ]);

    $atleta = Atleta::create([
        'nome' => 'João Silva',
        'user_id' => $user->id,
        'modalidade' => ['Futsal'],
    ]);

    $this->assertDatabaseHas('atletas', [
        'nome' => 'João Silva',
        'user_id' => $user->id,
    ]);
});

test('atleta update via direct model', function () {
    $user = User::factory()->create([
        'active' => true,
        'password' => bcrypt('password'),
    ]);

    $atleta = Atleta::create([
        'nome' => 'Original Name',
        'user_id' => $user->id,
        'modalidade' => ['Futsal'],
    ]);

    $atleta->update(['nome' => 'Updated Name']);

    $this->assertDatabaseHas('atletas', [
        'id' => $atleta->id,
        'nome' => 'Updated Name',
    ]);
});

test('atleta deletion via direct model', function () {
    $user = User::factory()->create([
        'active' => true,
        'password' => bcrypt('password'),
    ]);

    $atleta = Atleta::create([
        'nome' => 'To Delete',
        'user_id' => $user->id,
        'modalidade' => ['Futsal'],
    ]);

    $atleta->delete();

    $this->assertDatabaseMissing('atletas', ['id' => $atleta->id]);
});

test('sub user creation via direct model', function () {
    $parent = User::factory()->create([
        'role' => 'parent',
        'active' => true,
    ]);

    $subUser = User::factory()->create([
        'name' => 'Sub User Test',
        'email' => 'sub@example.com',
        'role' => 'sub_user',
        'parent_id' => $parent->id,
    ]);

    $this->assertDatabaseHas('users', [
        'name' => 'Sub User Test',
        'email' => 'sub@example.com',
        'role' => 'sub_user',
        'parent_id' => $parent->id,
    ]);
});

test('sub user team name can be updated', function () {
    $parent = User::factory()->create([
        'role' => 'parent',
        'active' => true,
    ]);

    $subUser = User::factory()->create([
        'role' => 'sub_user',
        'parent_id' => $parent->id,
        'active' => true,
        'password' => bcrypt('password'),
    ]);

    $subUser->update(['team_name' => 'Time Azul']);

    $subUser->refresh();
    expect($subUser->team_name)->toBe('Time Azul');
});
