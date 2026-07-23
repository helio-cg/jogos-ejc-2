<?php

use App\Models\User;
use App\Models\Atleta;
use App\Models\Paroquia;

test('welcome page is accessible', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});

test('regulamento page is accessible', function () {
    $response = $this->get('/regulamento');

    $response->assertStatus(200);
});

test('pdf route is accessible without auth', function () {
    $user = User::factory()->create();

    $response = $this->get("/pdf/comprovante/{$user->id}");

    $response->assertStatus(200);
    $response->assertHeader('content-type', 'application/pdf');
});

test('pdf route generates pdf with atletas data', function () {
    $user = User::factory()->create([
        'password' => bcrypt('password'),
        'active' => true,
    ]);

    $paroquia = Paroquia::create(['name' => 'São José', 'city' => 'Fortaleza']);
    $user->update(['paroquia_id' => $paroquia->id]);

    Atleta::create([
        'nome' => 'João Silva',
        'user_id' => $user->id,
        'modalidade' => ['Futsal'],
        'pagamento' => true,
    ]);

    $response = $this->get("/pdf/comprovante/{$user->id}");

    $response->assertStatus(200);
    $response->assertHeader('content-type', 'application/pdf');
});

test('pdf route includes child user atletas for parent', function () {
    $parent = User::factory()->create([
        'role' => 'parent',
        'password' => bcrypt('password'),
        'active' => true,
    ]);

    $paroquia = Paroquia::create(['name' => 'São José', 'city' => 'Fortaleza']);
    $parent->update(['paroquia_id' => $paroquia->id]);

    $child = User::factory()->create([
        'role' => 'sub_user',
        'parent_id' => $parent->id,
        'paroquia_id' => $paroquia->id,
    ]);

    Atleta::create([
        'nome' => 'Atleta do Pai',
        'user_id' => $parent->id,
        'modalidade' => ['Futsal'],
        'pagamento' => true,
    ]);

    Atleta::create([
        'nome' => 'Atleta do Filho',
        'user_id' => $child->id,
        'modalidade' => ['Volei'],
        'pagamento' => true,
    ]);

    $response = $this->get("/pdf/comprovante/{$parent->id}");

    $response->assertStatus(200);
});

test('admin switch back redirects to admin', function () {
    $response = $this->get('/admin/switch/back');

    $response->assertRedirect('/admin');
});
