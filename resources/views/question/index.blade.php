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

        {{-- Listagem de perguntas em rascunho --}}

        <hr class="border-gray-700 border-dashed my-4">

        <div class="dark:text-gray-400 uppercase font-bold mb-1">Drafts</div>

        <div class="dark:text-gray-400 space-y-4 mt-1.5">
            <x-table>
                <x-table.thead>
                    <tr>
                        <x-table.th>Question</x-table.th>
                        <x-table.th>Actions</x-table.th>
                    </tr>
                </x-table.thead>
                <tbody>
                    @foreach($questions->where('draft', true) as $question)
                        <x-table.tr>
                            <x-table.td>{{$question->question}}</x-table.td>
                            <x-table.td>
                                <x-form :action="route('question.publish', $question)" put >
                                    <button type="submit" class="hover:underline text-green-500">
                                        Publish
                                    </button>
                                </x-form>

                                <a class="hover:underline text-blue-500" href="{{route('question.edit', $question)}}">Edit</a>

                                <x-form :action="route('question.destroy', $question)" delete onSubmit="return confirm('Tem certeza?')">
                                    <button type="submit" class="hover:underline text-red-600">
                                        Delete
                                    </button>
                                </x-form>

                            </x-table.td>
                        </x-table.tr>
                    @endforeach
                </tbody>
            </x-table>
        </div>

        {{-- Listagem de perguntas --}}

        <hr class="border-gray-700 border-dashed my-4">


        <div class="dark:text-gray-400 uppercase font-bold mb-1">My questions</div>

        <div class="dark:text-gray-400 space-y-4">
            <x-table>
                <x-table.thead>
                    <tr>
                        <x-table.th>Question</x-table.th>
                        <x-table.th>Actions</x-table.th>
                    </tr>
                </x-table.thead>
                <tbody>
                @foreach($questions->where('draft', false) as $question)
                    <x-table.tr>
                        <x-table.td>{{$question->question}}</x-table.td>
                        <x-table.td>
                            <x-form :action="route('question.destroy', $question)" delete onSubmit="return confirm('Tem certeza?')">
                                <button type="submit" class="hover:underline text-red-600">
                                    Delete
                                </button>
                            </x-form>

                            <x-form :action="route('question.archive', $question)" patch >
                                <button type="submit" class="hover:underline text-purple-600">
                                    Archive
                                </button>
                            </x-form>
                        </x-table.td>
                    </x-table.tr>
                @endforeach
                </tbody>
            </x-table>
        </div>

        {{-- Listagem de perguntas arquivadas --}}

        <hr class="border-gray-700 border-dashed my-4">


        <div class="dark:text-gray-400 uppercase font-bold mb-1">Archived</div>

        <div class="dark:text-gray-400 space-y-4">
            <x-table>
                <x-table.thead>
                    <tr>
                        <x-table.th>Question</x-table.th>
                        <x-table.th>Actions</x-table.th>
                    </tr>
                </x-table.thead>
                <tbody>
                @foreach($archivedQuestions as $question)
                    <x-table.tr>
                        <x-table.td>{{$question->question}}</x-table.td>
                        <x-table.td>
                            <x-form :action="route('question.destroy', $question)" delete onSubmit="return confirm('Tem certeza?')">
                                <button type="submit" class="hover:underline text-red-600">
                                    Delete
                                </button>
                            </x-form>

                            <x-form :action="route('question.restore', $question)" patch >
                                <button type="submit" class="hover:underline text-amber-500">
                                    Restore
                                </button>
                            </x-form>
                        </x-table.td>
                    </x-table.tr>
                @endforeach
                </tbody>
            </x-table>
        </div>
    </x-container>

</x-app-layout>
