<?php

declare(strict_types=1);

it('returns a successful response', function () {
    visit('/register')
        ->fill('name', 'John Doe')
        ->fill('email', 'john@example.com')
        ->fill('password', 'topsecret')
        ->click('Create Account')
        ->assertPathIs('/');

    $this->assertAuthenticated();

//    $this->assertDatabaseHas('users', [
//        'name' => 'John Doe',
//    ]);

    expect(Auth::user())->toMatchArray([
        'name' => 'John Doe',
    ]);
});
