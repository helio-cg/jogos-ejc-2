<?php

use App\Models\User;
use App\Models\Atleta;
use App\Models\Paroquia;

test('user can access user panel', function () {
    $user = User::factory()->create([
        'active' => true,
        'password' => bcrypt('password'),
    ]);

    $this->actingAs($user, 'web');

    $response = $this->get('/user');

    $response->assertStatus(200);
});

test('unauthenticated user cannot access user panel', function () {
    $response = $this->get('/user');

    $response->assertRedirect();
});

test('user can view atletas resource', function () {
    $user = User::factory()->create([
        'active' => true,
        'password' => bcrypt('password'),
    ]);

    $paroquia = Paroquia::create(['name' => 'São José', 'city' => 'Fortaleza']);
    $user->update(['paroquia_id' => $paroquia->id]);

    $this->actingAs($user, 'web');

    $response = $this->get('/user/atletas');

    $response->assertStatus(200);
});

test('parent can view sub users resource', function () {
    $parent = User::factory()->create([
        'role' => 'parent',
        'active' => true,
        'password' => bcrypt('password'),
    ]);

    $this->actingAs($parent, 'web');

    $response = $this->get('/user/sub-users');

    $response->assertStatus(200);
});

test('sub_user cannot view sub users resource', function () {
    $subUser = User::factory()->create([
        'role' => 'sub_user',
        'active' => true,
        'password' => bcrypt('password'),
    ]);

    $this->actingAs($subUser, 'web');

    $response = $this->get('/user/sub-users');

    $response->assertForbidden();
});

test('parent can view activity logs', function () {
    $parent = User::factory()->create([
        'role' => 'parent',
        'active' => true,
        'password' => bcrypt('password'),
    ]);

    $this->actingAs($parent, 'web');

    $response = $this->get('/user/activity-logs');

    $response->assertStatus(200);
});

test('sub_user cannot view activity logs', function () {
    $subUser = User::factory()->create([
        'role' => 'sub_user',
        'active' => true,
        'password' => bcrypt('password'),
    ]);

    $this->actingAs($subUser, 'web');

    $response = $this->get('/user/activity-logs');

    $response->assertForbidden();
});

test('parent can view gerenciar pagamentos page', function () {
    $parent = User::factory()->create([
        'role' => 'parent',
        'active' => true,
        'password' => bcrypt('password'),
    ]);

    $this->actingAs($parent, 'web');

    $response = $this->get('/user/gerenciar-pagamentos');

    $response->assertStatus(200);
});

test('sub_user cannot view gerenciar pagamentos page', function () {
    $subUser = User::factory()->create([
        'role' => 'sub_user',
        'active' => true,
        'password' => bcrypt('password'),
    ]);

    $this->actingAs($subUser, 'web');

    $response = $this->get('/user/gerenciar-pagamentos');

    $response->assertForbidden();
});

test('user atletas are scoped to parish', function () {
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
        'nome' => 'Atleta Mesa',
        'user_id' => $sameParishUser->id,
        'modalidade' => ['Futsal'],
    ]);
    Atleta::create([
        'nome' => 'Atleta Outra',
        'user_id' => $differentParishUser->id,
        'modalidade' => ['Volei'],
    ]);

    $this->actingAs($user, 'web');

    $response = $this->get('/user/atletas');

    $response->assertStatus(200);
});

test('user stats overview shows correct parish data', function () {
    $paroquia = Paroquia::create(['name' => 'São José', 'city' => 'Fortaleza']);
    $user = User::factory()->create([
        'active' => true,
        'password' => bcrypt('password'),
        'paroquia_id' => $paroquia->id,
    ]);

    Atleta::create([
        'nome' => 'Atleta 1',
        'user_id' => $user->id,
        'modalidade' => ['Futsal'],
        'pagamento' => true,
    ]);
    Atleta::create([
        'nome' => 'Atleta 2',
        'user_id' => $user->id,
        'modalidade' => ['Volei'],
        'pagamento' => false,
    ]);

    $this->actingAs($user, 'web');

    $response = $this->get('/user');

    $response->assertStatus(200);
});
