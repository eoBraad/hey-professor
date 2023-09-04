<x-app-layout>
    <x-slot name="header">
        <x-header>
            {{ __('Edit question ') }} :: {{ $question->id }}
        </x-header>
    </x-slot>

    <x-container>
        <x-form :action="route('question.update', $question)" put>
            <x-textarea name="question" label="Question" :value="$question->question"/>

            <x-btn.primary type='submit'>Save</x-btn.primary>
            <a href="{{route('question.index')}}" class="
    py-2.5 px-5 mr-2 mb-2 text-sm font-medium
    text-gray-900 focus:outline-none bg-white
    rounded-full border border-gray-200 hover:bg-
    gray-100 hover:text-blue-700 focus:z-10 focus:ring-4
    focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800
    dark:text-gray-400 dark:border-gray-600 dark:hover:text-white
    dark:hover:bg-gray-700">Cancel</a>
        </x-form>
    </x-container>

</x-app-layout>
