<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, assertDatabaseCount, assertDatabaseHas, put};

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

it('should be able update a new question bigger than 255 characters', function () {
    // Arrange :: Preparar
    $user = User::factory()->create();
    actingAs($user);

    $question = Question::factory()->for($user, 'createdBy')->create(['draft' => true]);
    // Act :: Agir
    $request = put(route('question.update', $question), [
        'question' => str_repeat('*', 256) . '?',
    ]);

    // Assert :: Verificar
    $request->assertRedirect();
    assertDatabaseHas('questions', ['question' => str_repeat('*', 256) . '?']);

});

it('should check if ends with question mark ?', function () {

    // Arrange :: Preparar
    $user = User::factory()->create();
    actingAs($user);

    $question = Question::factory()->for($user, 'createdBy')->create(['draft' => true]);
    // Act :: Agir
    $request = put(route('question.update', $question), [
        'question' => str_repeat('*', 10),
    ]);

    // Assert :: Verificar
    $request->assertSessionHasErrors([
        'question' => 'Are you sure that is a question? It is missing the question mark in the end.',
    ]);

    $question->refresh();

    expect($question->question)->not->toBe(str_repeat('*', 10));
});

it('should have at least 10 characters', function () {

    // Arrange :: Preparar
    $user = User::factory()->create();
    actingAs($user);

    $question = Question::factory()->for($user, 'createdBy')->create(['draft' => true]);
    // Act :: Agir
    $request = put(route('question.update', $question), [
        'question' => str_repeat('*', 8) . '?',
    ]);

    // Assert :: Verificar
    $request->assertSessionHasErrors(['question' => __('validation.min.string', ['min' => 10, 'attribute' => 'question'])]);

    $question->refresh();

    expect(str_word_count($question->question))->not->toBe(8);
});
