<?php

use App\Models\ActivityLog;
use App\Models\User;

test('activity log can be created', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $log = ActivityLog::log(
        'test_action',
        'Test description',
        User::class,
        $user->id,
        ['key' => 'value']
    );

    expect($log)->toBeInstanceOf(ActivityLog::class);
    expect($log->action)->toBe('test_action');
    expect($log->description)->toBe('Test description');
    expect($log->model_type)->toBe(User::class);
    expect($log->model_id)->toBe($user->id);
    expect($log->properties)->toBe(['key' => 'value']);
});

test('activity log belongs to user', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $log = ActivityLog::log('test', 'Test');

    expect($log->user)->toBeInstanceOf(User::class);
    expect($log->user->id)->toBe($user->id);
});

test('activity log can be created without user', function () {
    $log = ActivityLog::log('test', 'Test');

    expect($log->user_id)->toBeNull();
});

test('activity log properties are cast to array', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $log = ActivityLog::log('test', 'Test', null, null, ['foo' => 'bar']);

    expect($log->properties)->toBeArray();
    expect($log->properties)->toHaveKey('foo');
    expect($log->properties['foo'])->toBe('bar');
});

test('activity log stores nullable model type and id', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $log = ActivityLog::log('test', 'Test', null, null, null);

    expect($log->model_type)->toBeNull();
    expect($log->model_id)->toBeNull();
});

test('activity log captures authenticated user id', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $log = ActivityLog::log('test', 'Test');

    expect($log->user_id)->toBe($user->id);
});

test('activity log timestamps are set', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $log = ActivityLog::log('test', 'Test');

    expect($log->created_at)->not->toBeNull();
    expect($log->updated_at)->not->toBeNull();
});
