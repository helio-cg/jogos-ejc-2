<?php

use App\Models\User;
use App\Models\Admin;
use App\Models\Paroquia;

test('welcome page returns successful response', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});

test('regulamento page returns successful response', function () {
    $response = $this->get('/regulamento');

    $response->assertStatus(200);
});

test('user login page is accessible', function () {
    $response = $this->get('/user/login');

    $response->assertStatus(200);
});

test('admin login page is accessible', function () {
    $response = $this->get('/admin/login');

    $response->assertStatus(200);
});

test('unauthenticated user is redirected to login', function () {
    $response = $this->get('/user');

    $response->assertRedirect();
});

test('admin switch user requires admin auth', function () {
    $user = User::factory()->create();

    $response = $this->get("/admin/switch/user/{$user->id}");

    $response->assertStatus(500);
});

test('admin can switch to user', function () {
    $admin = Admin::factory()->create();
    $user = User::factory()->create();

    $this->actingAs($admin, 'admin');

    $response = $this->get("/admin/switch/user/{$user->id}");

    $response->assertRedirect('/user');
    $this->assertAuthenticatedAs($user, 'web');
    expect(session('admin_id'))->toBe($admin->id);
});

test('admin can switch back from user', function () {
    $admin = Admin::factory()->create();
    $user = User::factory()->create();

    $this->actingAs($admin, 'admin');
    $this->get("/admin/switch/user/{$user->id}");

    $this->actingAs($user, 'web');
    session(['admin_id' => $admin->id]);

    $response = $this->get('/admin/switch/back');

    $response->assertRedirect('/admin');
    $this->assertAuthenticatedAs($admin, 'admin');
});

test('admin switch to non-existent user returns 404', function () {
    $admin = Admin::factory()->create();

    $this->actingAs($admin, 'admin');

    $response = $this->get('/admin/switch/user/99999');

    $response->assertStatus(404);
});
