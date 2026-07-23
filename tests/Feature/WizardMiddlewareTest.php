<?php

use App\Models\User;
use App\Models\Paroquia;

test('inactive user is redirected to activation page', function () {
    $user = User::factory()->create([
        'active' => false,
        'password' => bcrypt('password'),
    ]);

    $this->actingAs($user, 'web');

    $response = $this->get('/user');

    $response->assertRedirect(route('ativar-conta'));
});

test('active user is not redirected to activation page', function () {
    $user = User::factory()->create([
        'active' => true,
        'password' => bcrypt('password'),
    ]);

    $this->actingAs($user, 'web');

    $response = $this->get('/user');

    $response->assertStatus(200);
});

test('activation page does not redirect active users', function () {
    $user = User::factory()->create([
        'active' => true,
        'password' => bcrypt('password'),
    ]);

    $this->actingAs($user, 'web');

    $response = $this->get('/ativar-conta');

    $response->assertStatus(200);
});

test('user activation updates active status', function () {
    $paroquia = Paroquia::create(['name' => 'São José', 'city' => 'Fortaleza']);
    $user = User::factory()->create([
        'active' => false,
        'password' => bcrypt('password'),
        'paroquia_id' => null,
    ]);

    $this->actingAs($user, 'web');

    $user->update([
        'whatsapp' => '(88) 99999-9999',
        'paroquia_id' => $paroquia->id,
        'active' => true,
    ]);

    $user->refresh();
    expect($user->active)->toBeTrue();
    expect($user->whatsapp)->toBe('(88) 99999-9999');
    expect($user->paroquia_id)->toBe($paroquia->id);
});

test('wizard middleware blocks inactive users', function () {
    $user = User::factory()->create([
        'active' => false,
        'password' => bcrypt('password'),
    ]);

    $this->actingAs($user, 'web');

    $response = $this->get('/user/atletas');

    $response->assertRedirect(route('ativar-conta'));
});

test('wizard middleware allows active users', function () {
    $user = User::factory()->create([
        'active' => true,
        'password' => bcrypt('password'),
    ]);

    $this->actingAs($user, 'web');

    $response = $this->get('/user/atletas');

    $response->assertStatus(200);
});
