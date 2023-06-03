<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, put};

it("should be able to publish a question", function () {
    $user = User::factory()->create();
    actingAs($user);

    $question = Question::factory()
    ->for($user, 'createdBy')
    ->create(["draft" => true]);

    put(route("question.publish", $question))
        ->assertRedirect();

    expect($question->fresh()->draft)->toBeFalse();
});

it("should make sure that only the person who has created can publish the question", function () {
    $rightUser = User::factory()->create();
    $wrongUser = User::factory()->create();
    $question  = Question::factory()->create(["draft" => true, 'created_by' => $rightUser->id]);

    actingAs($wrongUser);

    put(route("question.publish", $question))->assertForbidden();

    actingAs($rightUser);

    put(route("question.publish", $question))->assertRedirect();
});
