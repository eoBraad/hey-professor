@props(['question'])


<div
    class="flex items-center justify-between rounded p-3 shadow shadow-blue-500/50 dark:bg-gray-800/50 dark:text-gray-400">
    <span>{{ $question->question }}</span>
    <div class="flex gap-4">
        <x-form :action="route('question.like', $question->id)">
            <button class="flex items-center space-x-1 text-green-500">
                <x-icons.thumbs-up class="h-5 w-5 cursor-pointer hover:brightness-75" />
                <span>{{ $question->likes }}</span>
            </button>
        </x-form>

        <x-form :action="route('question.unlike', $question->id)">
            <button href="" class="flex items-center space-x-1 text-red-700">
                <x-icons.thumbs-down class="h-5 w-5 cursor-pointer hover:brightness-75" />
                <span>{{ $question->unlikes }}</span>
            </button>
        </x-form>
    </div>
</div>
