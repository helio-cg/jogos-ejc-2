<?php

use App\Models\Paroquia;
use App\Models\User;
use App\Models\Atleta;

test('paroquia can be created', function () {
    $paroquia = Paroquia::create([
        'name' => 'São José',
        'city' => 'Fortaleza',
    ]);

    expect($paroquia)->toBeInstanceOf(Paroquia::class);
    expect($paroquia->name)->toBe('São José');
    expect($paroquia->city)->toBe('Fortaleza');
});

test('paroquia has no timestamps', function () {
    $paroquia = Paroquia::create([
        'name' => 'São José',
        'city' => 'Fortaleza',
    ]);

    expect($paroquia->created_at)->toBeNull();
    expect($paroquia->updated_at)->toBeNull();
});

test('paroquia has many users', function () {
    $paroquia = Paroquia::create(['name' => 'São José', 'city' => 'Fortaleza']);
    User::factory()->create(['paroquia_id' => $paroquia->id]);
    User::factory()->create(['paroquia_id' => $paroquia->id]);

    expect($paroquia->users)->toHaveCount(2);
});

test('paroquia has many atletas through users', function () {
    $paroquia = Paroquia::create(['name' => 'São José', 'city' => 'Fortaleza']);
    $user = User::factory()->create(['paroquia_id' => $paroquia->id]);
    Atleta::create([
        'nome' => 'João',
        'user_id' => $user->id,
        'modalidade' => ['Futsal'],
    ]);

    expect($paroquia->users->first()->atleta)->toHaveCount(1);
});
