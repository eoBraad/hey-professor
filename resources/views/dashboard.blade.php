<x-app-layout>
    <x-slot name="header">
        <x-header>
            {{ __('Vote for a question') }}
        </x-header>
    </x-slot>

    <x-container>
        {{-- Listagem de perguntas --}}
        <div class="dark:text-gray-400 uppercase font-bold mb-4">
            <form method="get" action="{{route('dashboard')}}" class="flex items-center space-x-2">
                <x-text-input type="text" name="search" value="{{request()->search}}" class="w-full" placeholder="Search a question"/>
                <x-btn.primary type="submit">Search</x-btn.primary>
            </form>
        </div>


        <div class="dark:text-gray-400 space-y-4">
            @if($questions->isEmpty())
                <div class="flex flex-col items-center justify-center dark:text-gray-300 mt-24">
                    <x-draw.searching width="400"/>

                    <div class="dark:text-gray-500 mt-4 font-bold text-2xl">Question not found</div>
                </div>
            @else
                @foreach ($questions as $item)
                    <x-question :question="$item" />
                @endforeach

                {{ $questions->withQueryString()->links()  }}
            @endif
        </div>
    </x-container>

</x-app-layout>
