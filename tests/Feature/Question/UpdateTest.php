<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, put};

it('should be able to update a question', function () {
    $user     = User::factory()->create();
    $question = Question::factory()->for($user, 'createdBy')->create(['draft' => true]);

    actingAs($user);

    put(route('question.update', $question), [
        'question' => 'updated the question?',
    ])->assertRedirect();

    $question->refresh();

    expect($question->question)->toBe('updated the question?');
});

it('should make sure that only question with status DRAFT can be update', function () {
    $user = User::factory()->create();

    $questionNotDraft = Question::factory()->for($user, 'createdBy')->create(['draft' => false]);

    $question = Question::factory()->for($user, 'createdBy')->create(['draft' => true]);

    actingAs($user);

    put(route('question.update', $questionNotDraft), [
        'question' => 'updated a question?',
    ])->assertForbidden();

    put(route('question.update', $question), [
        'question' => 'updated a question?',
    ])->assertRedirect();

    $question->refresh();
    expect($question->question)->toBe('updated a question?');
});

it("should make sure that only the person who has created can update the question", function () {
    $rightUser = User::factory()->create();
    $wrongUser = User::factory()->create();
    $question  = Question::factory()->create(["draft" => true, 'created_by' => $rightUser->id]);

    actingAs($wrongUser);

    put(route("question.update", $question), [
        'question' => 'updated a question?',
    ])->assertForbidden();

    actingAs($rightUser);

    put(route("question.update", $question), [
        'question' => 'updated a question?',
    ])->assertRedirect();
});
