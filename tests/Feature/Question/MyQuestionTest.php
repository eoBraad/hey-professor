<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, get};

it('should be able to list all question created by me', function () {
    $user = User::factory()->create();

    $wrongUser = User::factory()->create();

    $wrongQuestion = Question::factory()
        ->for($wrongUser, 'createdBy')
        ->count(10)
        ->create();

    $questions = Question::factory()
        ->for($user, 'createdBy')
        ->count(10)
        ->create();

    // Act
    actingAs($user);
    $response = get(route('question.index'));

    // Assert

    /** @var Question $q  */
    foreach($questions as $q) {
        $response->assertSee($q->question);
    }

    /** @var Question $q  */
    foreach($wrongQuestion as $q) {
        $response->assertDontSee($q->question);
    }

});
