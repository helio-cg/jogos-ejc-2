<?php

use App\Models\Atleta;
use App\Models\User;
use App\Models\ActivityLog;

test('atleta can be created', function () {
    $user = User::factory()->create();
    $atleta = Atleta::create([
        'nome' => 'João Silva',
        'conhecido_como' => 'Jão',
        'data_nascimento' => '2000-01-15',
        'modalidade' => ['Futsal', 'Volei'],
        'user_id' => $user->id,
    ]);

    expect($atleta)->toBeInstanceOf(Atleta::class);
    expect($atleta->nome)->toBe('João Silva');
    expect($atleta->conhecido_como)->toBe('Jão');
    expect($atleta->modalidade)->toBe(['Futsal', 'Volei']);
});

test('atleta belongs to user', function () {
    $user = User::factory()->create();
    $atleta = Atleta::create([
        'nome' => 'Maria Santos',
        'user_id' => $user->id,
        'modalidade' => ['Queimada'],
    ]);

    expect($atleta->user)->toBeInstanceOf(User::class);
    expect($atleta->user->id)->toBe($user->id);
});

test('atleta modalidade is cast to array', function () {
    $user = User::factory()->create();
    $atleta = Atleta::create([
        'nome' => 'Pedro',
        'user_id' => $user->id,
        'modalidade' => ['Futsal'],
    ]);

    expect($atleta->modalidade)->toBeArray();
    expect($atleta->modalidade)->toContain('Futsal');
});

test('atleta defaults to pagamento false', function () {
    $user = User::factory()->create();
    $atleta = Atleta::create([
        'nome' => 'Ana',
        'user_id' => $user->id,
        'modalidade' => ['Volei'],
    ]);

    expect($atleta->pagamento)->toBeFalsy();
});

test('atleta data_nascimento is cast to date', function () {
    $user = User::factory()->create();
    $atleta = Atleta::create([
        'nome' => 'Carlos',
        'data_nascimento' => '1995-06-20',
        'user_id' => $user->id,
        'modalidade' => ['Futsal'],
    ]);

    expect($atleta->data_nascimento)->toBeInstanceOf(\Carbon\Carbon::class);
});

test('atleta logs creation activity', function () {
    $user = User::factory()->create();

    Atleta::create([
        'nome' => 'Lucas',
        'conhecido_como' => 'Lu',
        'user_id' => $user->id,
        'modalidade' => ['Futsal', 'Queimada'],
    ]);

    $log = ActivityLog::latest()->first();

    expect($log)->not->toBeNull();
    expect($log->action)->toBe('atleta_criado');
    expect($log->description)->toContain('Lucas');
    expect($log->description)->toContain('Futsal');
    expect($log->description)->toContain('Queimada');
    expect($log->model_type)->toBe(Atleta::class);
});

test('atleta logs update activity', function () {
    $user = User::factory()->create();
    $atleta = Atleta::create([
        'nome' => 'Original',
        'user_id' => $user->id,
        'modalidade' => ['Futsal'],
    ]);

    ActivityLog::query()->delete();

    $atleta->update(['nome' => 'Atualizado']);

    $log = ActivityLog::latest()->first();

    expect($log)->not->toBeNull();
    expect($log->action)->toBe('atleta_atualizado');
    expect($log->description)->toContain('Atualizado');
});

test('atleta logs modalidade changes', function () {
    $user = User::factory()->create();
    $atleta = Atleta::create([
        'nome' => 'Teste',
        'user_id' => $user->id,
        'modalidade' => ['Futsal'],
    ]);

    ActivityLog::query()->delete();

    $atleta->update(['modalidade' => ['Futsal', 'Volei']]);

    $log = ActivityLog::latest()->first();

    expect($log)->not->toBeNull();
    expect($log->description)->toContain('Volei');
});

test('atleta logs deletion activity', function () {
    $user = User::factory()->create();
    $atleta = Atleta::create([
        'nome' => 'Deletado',
        'user_id' => $user->id,
        'modalidade' => ['Queimada'],
    ]);

    ActivityLog::query()->delete();

    $atleta->delete();

    $log = ActivityLog::latest()->first();

    expect($log)->not->toBeNull();
    expect($log->action)->toBe('atleta_removido');
    expect($log->description)->toContain('Deletado');
});

test('atleta is deleted when user is deleted', function () {
    $user = User::factory()->create();
    Atleta::create([
        'nome' => 'Órfão',
        'user_id' => $user->id,
        'modalidade' => ['Futsal'],
    ]);

    $user->delete();

    expect(Atleta::count())->toBe(0);
});

test('atleta pagamento can be toggled', function () {
    $user = User::factory()->create();
    $atleta = Atleta::create([
        'nome' => 'Pagante',
        'user_id' => $user->id,
        'modalidade' => ['Futsal'],
        'pagamento' => false,
    ]);

    $atleta->update(['pagamento' => true]);
    expect($atleta->fresh()->pagamento)->toBe(1);

    $atleta->update(['pagamento' => false]);
    expect($atleta->fresh()->pagamento)->toBe(0);
});

test('atleta logs pagamento change', function () {
    $user = User::factory()->create();
    $atleta = Atleta::create([
        'nome' => 'Teste Pagamento',
        'user_id' => $user->id,
        'modalidade' => ['Futsal'],
        'pagamento' => false,
    ]);

    ActivityLog::query()->delete();

    $atleta->update(['pagamento' => true]);

    $log = ActivityLog::latest()->first();

    expect($log)->not->toBeNull();
    expect($log->description)->toContain('Pago');
});

test('atleta can have multiple modalidades', function () {
    $user = User::factory()->create();
    $atleta = Atleta::create([
        'nome' => 'Multi-Modal',
        'user_id' => $user->id,
        'modalidade' => ['Futsal', 'Volei', 'Queimada'],
    ]);

    expect($atleta->modalidade)->toHaveCount(3);
    expect($atleta->modalidade)->toContain('Futsal');
    expect($atleta->modalidade)->toContain('Volei');
    expect($atleta->modalidade)->toContain('Queimada');
});
