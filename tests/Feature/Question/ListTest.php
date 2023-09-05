<?php

use App\Models\{ Question, User };
use Illuminate\Pagination\LengthAwarePaginator;

use function Pest\Laravel\{actingAs, get};

it('should list all the questions', function () {
    // Arrange :: Preparar
    $user = User::factory()->create();
    actingAs($user);
    $questions = Question::factory()->count(5)->create();

    // Act
    $response = get(route('dashboard'));

    // Assert

    /** @var Question $q  */
    foreach($questions as $q) {
        $response->assertSee($q->question);
    }
});

it('should paginate the result', function () {
    $user      = User::factory()->create();
    $questions = Question::factory()->count(40)->create();

    actingAs($user);
    get(route('dashboard'))
        ->assertViewHas('questions', fn ($value) => $value instanceof LengthAwarePaginator && $value->count() == 5);

});

it('should order by like and unlike, most liked question should be at the top, most unliked questions should be in the bottom', function () {
    $user       = User::factory()->create();
    $secondUser = User::factory()->create();

    Question::factory()->count(5)->create();

    $mostLikedQuestion   = Question::find(3);
    $mostUnlikedQuestion = Question::find(1);

    $user->like($mostLikedQuestion);
    $secondUser->unlike($mostUnlikedQuestion);

    actingAs($user);

    get(route('dashboard'))
        ->assertViewHas('questions', function ($questions) use ($mostLikedQuestion, $mostUnlikedQuestion) {
            expect($questions->first()->id)
                ->toBe(3)
                ->and($questions->last()->id)
                ->toBe(1);

            return true;
        });
});
