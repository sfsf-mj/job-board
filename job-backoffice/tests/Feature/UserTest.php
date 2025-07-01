<?php

use App\Models\User;

test('Create user that will pass validation', function (): void {

    // Arrange
    $data = [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'password',
        'role' => 'admin'
    ];

    // Act
    $user = User::create(attributes: $data);

    // Assert
    expect($user->name)->toBe(expected: $data['name']);
    expect($user->email)->toBe(expected: $data['email']);
    expect($user->role)->toBe(expected: $data['role']);
});

test('Create user that will fail validation', function (): void {

    // Arrange
    $data = [
        'name' => '',
        'email' => 'john@example.com'
    ];

    // Act
    try {
        $user = User::create($data);
        $failed = false;
    } catch (\Illuminate\Database\QueryException $e) {
        $failed = true;
    }

    // Assert
    expect($failed)->toBeTrue();
    expect(User::where('email', 'john@example.com')->exists())->toBeFalse();
});