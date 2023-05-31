<x-app-layout>
    <x-slot name="header">
        <x-header>
            {{ __('Dashboard') }}
        </x-header>
    </x-slot>

    <x-container>

        <x-form :action="route('question.store')" method="POST">
            <x-textarea name="question" label="Question" />

            <x-btn.primary type='submit'>Save</x-btn.primary>
            <x-btn.reset type='reset'>Cancel</x-btn.reset>
        </x-form>

        <hr class="border-gray-700 border-dashed my-4">

        {{-- Listagem de perguntas --}}

        <div class="dark:text-gray-400 uppercase font-bold mb-1">List of questions</div>

        <div class="dark:text-gray-400 space-y-4">
            @foreach ($questions as $item)
                <x-question :question="$item" />
            @endforeach
        </div>
    </x-container>

</x-app-layout>
