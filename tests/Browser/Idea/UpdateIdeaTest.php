<?php

use App\Models\Idea;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

it('can edit an idea', function () {
    $this->actingAs($user = User::factory()->create());
    $idea = Idea::factory()->for($user)->create();
    $image = UploadedFile::fake()->image('image.jpg');

    Storage::fake('public');

    visit(route('idea.show', $idea))
        ->click('@edit-idea-button')
        ->fill('title', 'Changed idea')
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
        ->click('Update')
        ->assertRoute('idea.show', ['idea' => $user->ideas()->first()]);

    $idea->refresh();

    Storage::disk('public')->assertExists($idea->image_path);

    expect($idea)->toMatchArray([
        'title' => 'Changed idea',
        'description' => 'This idea will be in progress',
        'status' => 'in_progress',
        'links' => [$idea->links[0], 'https://example.com/idea', 'https://laravel.com'],
    ])
        ->and($idea->steps)->toHaveCount(2);
});
