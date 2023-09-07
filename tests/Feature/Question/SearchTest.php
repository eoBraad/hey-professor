<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, get};

it('should be able to search a question by text', function () {
    $user = User::factory()->create();
    actingAs($user);
    Question::factory()->create(['question' => 'something else?']);
    Question::factory()->create(['question' => 'my question is?']);

    $response = get(route('dashboard', ['search' => 'question']));

    $response->assertDontSee('something else?');
    $response->assertSee('my question is?');
});
