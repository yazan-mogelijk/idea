<?php

declare(strict_types=1);

use App\Models\User;

it('logs in a user', function () {

    $user = User::factory()->create(['password' => 'passwordtopsecret']);

    visit('/login')
        ->fill('email', $user->email)
        ->fill('password', 'passwordtopsecret')
        ->click('@login-button')
        ->assertPathIs('/');

    $this->assertAuthenticated();
});

it('logs out a user', function () {

    $user = User::factory()->create();

    $this->actingAs($user);

    visit('/')->click('Logout');

    $this->assertGuest();
});

it('required a valid email', function () {
    visit('/register')
        ->fill('name', 'ssssss')
        ->fill('email', 'asdsadsaasdf')
        ->fill('password', 'passwordtopsecret')
        ->click('Create Account')
        ->assertPathIs('/register');
});
