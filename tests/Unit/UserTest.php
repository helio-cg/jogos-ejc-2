<?php

use App\Models\User;
use App\Models\Paroquia;
use App\Models\Atleta;

test('user can be created with factory', function () {
    $user = User::factory()->create();

    expect($user)->toBeInstanceOf(User::class);
    expect($user->name)->not->toBeEmpty();
    expect($user->email)->not->toBeEmpty();
    expect($user->password)->not->toBe('password');
});

test('user defaults to parent role', function () {
    $user = User::factory()->create();

    expect($user->role)->toBe('parent');
});

test('user defaults to incomplete status', function () {
    $user = User::factory()->create();

    expect($user->status)->toBe('incompleto');
});

test('user defaults to inactive', function () {
    $user = User::factory()->create();

    expect($user->active)->toBeFalse();
});

test('isParent returns true for parent role', function () {
    $user = User::factory()->create(['role' => 'parent']);

    expect($user->isParent())->toBeTrue();
});

test('isParent returns false for sub_user role', function () {
    $user = User::factory()->create(['role' => 'sub_user']);

    expect($user->isParent())->toBeFalse();
});

test('isSubUser returns true for sub_user role', function () {
    $user = User::factory()->create(['role' => 'sub_user']);

    expect($user->isSubUser())->toBeTrue();
});

test('isSubUser returns false for parent role', function () {
    $user = User::factory()->create(['role' => 'parent']);

    expect($user->isSubUser())->toBeFalse();
});

test('isCompleted returns true when status is completo', function () {
    $user = User::factory()->create(['status' => 'completo']);

    expect($user->isCompleted())->toBeTrue();
});

test('isCompleted returns false when status is incompleto', function () {
    $user = User::factory()->create(['status' => 'incompleto']);

    expect($user->isCompleted())->toBeFalse();
});

test('user belongs to paroquia', function () {
    $paroquia = Paroquia::create(['name' => 'São José', 'city' => 'Fortaleza']);
    $user = User::factory()->create(['paroquia_id' => $paroquia->id]);

    expect($user->paroquia)->toBeInstanceOf(Paroquia::class);
    expect($user->paroquia->name)->toBe('São José');
});

test('user has many atletas', function () {
    $user = User::factory()->create();
    Atleta::create([
        'nome' => 'João Silva',
        'user_id' => $user->id,
        'modalidade' => ['Futsal'],
    ]);
    Atleta::create([
        'nome' => 'Maria Santos',
        'user_id' => $user->id,
        'modalidade' => ['Volei'],
    ]);

    expect($user->atleta)->toHaveCount(2);
});

test('user has many children', function () {
    $parent = User::factory()->create(['role' => 'parent']);
    $child1 = User::factory()->create(['role' => 'sub_user', 'parent_id' => $parent->id]);
    $child2 = User::factory()->create(['role' => 'sub_user', 'parent_id' => $parent->id]);

    expect($parent->children)->toHaveCount(2);
});

test('user belongs to parent', function () {
    $parent = User::factory()->create(['role' => 'parent']);
    $child = User::factory()->create(['role' => 'sub_user', 'parent_id' => $parent->id]);

    expect($child->parent)->toBeInstanceOf(User::class);
    expect($child->parent->id)->toBe($parent->id);
});

test('sub_user gets auto-assigned team_name on creating', function () {
    $parent = User::factory()->create(['role' => 'parent']);
    $child = User::factory()->create([
        'role' => 'sub_user',
        'parent_id' => $parent->id,
    ]);

    expect($child->team_name)->not->toBeNull();
    expect($child->team_number)->not->toBeNull();
});

test('sub_user team_name increments for each child', function () {
    $parent = User::factory()->create(['role' => 'parent']);
    $child1 = User::factory()->create([
        'role' => 'sub_user',
        'parent_id' => $parent->id,
    ]);
    $child2 = User::factory()->create([
        'role' => 'sub_user',
        'parent_id' => $parent->id,
    ]);

    expect($child1->team_number)->toBe(1);
    expect($child2->team_number)->toBe(2);
});

test('getChildUserIds returns children ids', function () {
    $parent = User::factory()->create(['role' => 'parent']);
    $child1 = User::factory()->create(['role' => 'sub_user', 'parent_id' => $parent->id]);
    $child2 = User::factory()->create(['role' => 'sub_user', 'parent_id' => $parent->id]);

    $ids = $parent->getChildUserIds();

    expect($ids)->toContain($child1->id);
    expect($ids)->toContain($child2->id);
});

test('getAllVisibleUserIds returns self and children for parent', function () {
    $parent = User::factory()->create(['role' => 'parent']);
    $child = User::factory()->create(['role' => 'sub_user', 'parent_id' => $parent->id]);

    $ids = $parent->getAllVisibleUserIds();

    expect($ids)->toContain($parent->id);
    expect($ids)->toContain($child->id);
});

test('getAllVisibleUserIds returns only self for sub_user', function () {
    $parent = User::factory()->create(['role' => 'parent']);
    $child = User::factory()->create(['role' => 'sub_user', 'parent_id' => $parent->id]);

    $ids = $child->getAllVisibleUserIds();

    expect($ids)->toHaveCount(1);
    expect($ids)->toContain($child->id);
});

test('getParishUserIds returns active users from same paroquia', function () {
    $paroquia = Paroquia::create(['name' => 'São José', 'city' => 'Fortaleza']);
    $user = User::factory()->create(['paroquia_id' => $paroquia->id, 'active' => true]);
    $sameParish = User::factory()->create(['paroquia_id' => $paroquia->id, 'active' => true]);
    $differentParish = User::factory()->create(['active' => true]);
    $inactive = User::factory()->create(['paroquia_id' => $paroquia->id, 'active' => false]);

    $ids = $user->getParishUserIds();

    expect($ids)->toContain($user->id);
    expect($ids)->toContain($sameParish->id);
    expect($ids)->not->toContain($differentParish->id);
    expect($ids)->not->toContain($inactive->id);
});

test('user has many user modalidades', function () {
    $user = User::factory()->create();

    $user->userModalidades()->create(['modalidade' => 'Futsal']);
    $user->userModalidades()->create(['modalidade' => 'Volei']);

    expect($user->userModalidades)->toHaveCount(2);
});

test('user password is hashed', function () {
    $user = User::factory()->create(['password' => 'secret123']);

    expect($user->password)->not->toBe('secret123');
    expect(\Hash::check('secret123', $user->password))->toBeTrue();
});

test('user email is unique', function () {
    User::factory()->create(['email' => 'test@example.com']);

    $this->expectException(\Illuminate\Database\UniqueConstraintViolationException::class);

    User::factory()->create(['email' => 'test@example.com']);
});

test('user paroquia_id is nullable', function () {
    $user = User::factory()->create(['paroquia_id' => null]);

    expect($user->paroquia_id)->toBeNull();
    expect($user->paroquia)->toBeNull();
});
