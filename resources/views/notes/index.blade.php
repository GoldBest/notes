<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Notes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-end mb-10">
                <a href="{{ route('notes.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">Add note</a>
            </div>

            @if(count($notes))
                @foreach($notes as $note)
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-2">
                        <div class="p-6 pb-0 text-gray-900 dark:text-gray-100 text-3xl">
                            {{ $note->title }}
                        </div>
                        <div class="p-6 pb-0 pt-0 text-gray-900 dark:text-gray-100">
                            @if ($note->updated_at > $note->created_at)
                                {{ date('d.m.Y H:i:s', strtotime($note->created_at)) }} <small class="text-gray-600 ml-4">edit: {{ date('d.m.Y H:i:s', strtotime($note->updated_at)) }}</small>
                            @else
                                {{ date('d.m.Y H:i:s', strtotime($note->created_at)) }}
                            @endif
                        </div>
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            {{ $note->content }}
                        </div>

                        <div class="flex p-5 justify-between">
                            <x-nav-link :href="route('notes.edit', $note)" class="mr-3">
                                {{ __('Edit') }}
                            </x-nav-link>
                            <form method="POST" action="{{ route('notes.destroy', $note) }}" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <x-primary-button class="dark:bg-red-500 bg-red-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                </x-primary-button>
                            </form>
                        </div>
                    </div>
                @endforeach
                    <div class="mt-5">
                        {{ $notes->links() }}
                    </div>
            @else
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-2">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        {{ __("You don't have any notes yet.") }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
