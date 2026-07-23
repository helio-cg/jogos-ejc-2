<?php

use App\Models\Admin;
use App\Models\User;
use App\Models\Atleta;
use App\Models\Paroquia;

test('admin can access admin panel', function () {
    $admin = Admin::factory()->create();

    $this->actingAs($admin, 'admin');

    $response = $this->get('/admin');

    $response->assertStatus(200);
});

test('unauthenticated user cannot access admin panel', function () {
    $response = $this->get('/admin');

    $response->assertRedirect();
});

test('regular user is redirected from admin panel', function () {
    $user = User::factory()->create([
        'active' => true,
        'password' => bcrypt('password'),
    ]);

    $this->actingAs($user, 'web');

    $response = $this->get('/admin');

    $response->assertRedirect();
});

test('admin can view users resource', function () {
    $admin = Admin::factory()->create();

    $this->actingAs($admin, 'admin');

    $response = $this->get('/admin/users');

    $response->assertStatus(200);
});

test('admin can view atletas resource', function () {
    $admin = Admin::factory()->create();

    $this->actingAs($admin, 'admin');

    $response = $this->get('/admin/atletas');

    $response->assertStatus(200);
});

test('admin stats overview shows data', function () {
    $admin = Admin::factory()->create();
    $paroquia = Paroquia::create(['name' => 'São José', 'city' => 'Fortaleza']);

    User::factory()->count(3)->create(['paroquia_id' => $paroquia->id, 'active' => true]);

    $user = User::factory()->create(['paroquia_id' => $paroquia->id]);
    Atleta::create([
        'nome' => 'Atleta 1',
        'user_id' => $user->id,
        'modalidade' => ['Futsal'],
    ]);

    $this->actingAs($admin, 'admin');

    $response = $this->get('/admin');

    $response->assertStatus(200);
});
