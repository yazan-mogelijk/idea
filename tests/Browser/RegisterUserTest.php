<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Support\Facades\Hash;

test('the register page renders the form', function (): void {
    $this->get(route('register'))
        ->assertOk()
        ->assertSee('name="name"', false)
        ->assertSee('name="email"', false)
        ->assertSee('name="password"', false);
});

test('a guest can register and is logged in', function (): void {
    $response = $this->post(route('register.store'), [
        'name' => 'Jane Doe',
        'email' => 'jane@example.com',
        'password' => 'secret-password',
    ]);

    $response->assertRedirect('/');

    $user = User::firstWhere('email', 'jane@example.com');

    expect($user)->not->toBeNull()
        ->and($user->name)->toBe('Jane Doe')
        ->and(Hash::check('secret-password', $user->password))->toBeTrue();

    $this->assertAuthenticatedAs($user);
});

test('registration requires valid data', function (): void {
    $this->post(route('register.store'), [
        'name' => '',
        'email' => 'not-an-email',
        'password' => '',
    ])->assertSessionHasErrors(['name', 'email', 'password']);

    $this->assertGuest();
});

test('the email must be unique', function (): void {
    User::factory()->create(['email' => 'jane@example.com']);

    $this->post(route('register.store'), [
        'name' => 'Jane Doe',
        'email' => 'jane@example.com',
        'password' => 'secret-password',
    ])->assertSessionHasErrors('email');
});
