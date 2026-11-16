<?php

use App\Models\User;
use App\Notifications\EmailChanged;

it('requires authentication', function () {

    $this->get(route('profile.edit'))->assertRedirect(route('login'));
});

it('edits a profile', function () {

    $user = User::factory()->create();

    $this->actingAs($user);

    visit(route('profile.edit'))
        ->assertValue('name', $user->name)
        ->fill('name', 'New name')
        ->assertValue('email', $user->email)
        ->fill('email', 'new@email.com')
        ->click('Update Account')
        ->assertSee('Profile Updated Successfully!');

    expect($user->fresh())->toMatchArray([
        'name' => 'New name',
        'email' => 'new@email.com',
    ]);
});

it('notifies the original email if updated', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $originalEmail = $user->email;

    Notification::fake();

    visit(route('profile.edit'))
        ->assertValue('name', $user->name)
        ->fill('email', 'new@email.com')
        ->click('Update Account')
        ->assertSee('Profile Updated Successfully!');

    Notification::assertSentOnDemand(EmailChanged::class, function (EmailChanged $notification, $routes, $notifiable) use ($originalEmail): bool {

        return $notifiable->routes['mail'] === $originalEmail;
    });
});
