<?php

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

it('can create a new idea', function () {
    $this->actingAs($user = User::factory()->create());
    $image = UploadedFile::fake()->image('image.jpg');

    Storage::fake('public');

    visit(route('ideas'))
        ->click('@create-idea-button')
        ->fill('title', 'New idea')
        ->click('@button-status-in_progress')
        ->attach('image', $image->getPathname())
        ->fill('description', 'This idea will be in progress')
        ->fill('@new-link', 'https://example.com/idea')
        ->click('@submit-new-link-button')
        ->fill('@new-link', 'https://laravel.com')
        ->click('@submit-new-link-button')
        ->fill('@new-step', 'Do a thing')
        ->click('@submit-new-step-button')
        ->fill('@new-step', 'Do Another thing')
        ->click('@submit-new-step-button')
        ->click('Create')
        ->assertSee('You have created a new idea.')
        ->assertPathIs('/ideas');

    $idea = $user->ideas()->first();

    Storage::disk('public')->assertExists($idea->image_path);

    expect($idea)->toMatchArray([
        'title' => 'New idea',
        'description' => 'This idea will be in progress',
        'status' => 'in_progress',
        'links' => ['https://example.com/idea', 'https://laravel.com'],
    ])
        ->and($idea->steps)->toHaveCount(2);
});
