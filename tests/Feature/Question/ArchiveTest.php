<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, assertNotSoftDeleted, assertSoftDeleted, patch};

it('should be able to archive a question', function () {
    $user     = User::factory()->create();
    $question = Question::factory()
        ->for($user, 'createdBy')
        ->create(["draft" => true]);

    actingAs($user);

    patch(route("question.archive", $question))
        ->assertRedirect();

    assertSoftDeleted('questions', ['id' => $question->id]);

    expect($question->refresh()->deleted_at)->not->toBe(null);
});

it("should make sure that only the person who has created can archive the question", function () {
    $rightUser = User::factory()->create();
    $wrongUser = User::factory()->create();
    $question  = Question::factory()->create(["draft" => true, 'created_by' => $rightUser->id]);

    actingAs($wrongUser);

    patch(route("question.archive", $question))->assertForbidden();

    actingAs($rightUser);

    patch(route("question.archive", $question))->assertRedirect();
});

it('should be able to restore an archived question', function () {
    $user     = User::factory()->create();
    $question = Question::factory()
        ->for($user, 'createdBy')
        ->create(["draft" => true]);

    actingAs($user);

    patch(route("question.archive", $question));

    patch(route("question.restore", $question))
        ->assertRedirect();

    assertNotSoftDeleted('questions', ['id' => $question->id]);

    expect($question->refresh()->deleted_at)->toBe(null);
});
