<?php

use App\Models\User;

use function Pest\Laravel\{actingAs, assertDatabaseCount, assertDatabaseHas, post};

it('shold be able create a new question bigger than 255 characters', function () {
    // Arrange :: Preparar
    $user = User::factory()->create();
    actingAs($user);
    // Act :: Agir
    $request = post(route('question.store'), [
        'question' => str_repeat('*', 256) . '?',
    ]);

    // Assert :: Verificar
    $request->assertRedirect(route('dashboard'));
    assertDatabaseCount('questions', 1);
    assertDatabaseHas('questions', ['question' => str_repeat('*', 256) . '?']);

});

it('shold check if ends with question mark ?', function () {

})->todo();

it('should have at least 10 characters', function () {

})->todo();
