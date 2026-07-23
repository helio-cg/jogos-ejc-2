<?php

use App\Models\Admin;

test('admin can be created with factory', function () {
    $admin = Admin::factory()->create();

    expect($admin)->toBeInstanceOf(Admin::class);
    expect($admin->name)->not->toBeEmpty();
    expect($admin->email)->not->toBeEmpty();
});

test('admin password is hashed', function () {
    $admin = Admin::factory()->create(['password' => 'secret123']);

    expect($admin->password)->not->toBe('secret123');
    expect(\Hash::check('secret123', $admin->password))->toBeTrue();
});

test('admin email is unique', function () {
    Admin::factory()->create(['email' => 'admin@example.com']);

    $this->expectException(\Illuminate\Database\UniqueConstraintViolationException::class);

    Admin::factory()->create(['email' => 'admin@example.com']);
});

test('admin can access panel', function () {
    $admin = Admin::factory()->create();

    expect($admin->canAccessPanel(\Filament\Panel::make()->id('admin')))->toBeTrue();
});
