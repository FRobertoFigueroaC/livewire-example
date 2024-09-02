<div class="py-10">

    <div class="max-w-7xl px-4 mx-auto sm:px-6 lg:px-8">

        <div class="flex justify-between">
            <label for="search">
                <x-input wire:model.live.debounce.350ms="search"
                id="search"
                type="text"
                placeholder="Buscar..."/>
            </label>
            <a href="{{route('articles.create')}}"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50 transition ease-in-out duration-150">
                <svg class="w-6 h-6 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                    class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                {{__('New Article')}}
            </a>

              {{-- wire:model their values will be synchronized with the server's properties when the "Save" button is pressed --}}
              {{-- wire:model.live -> To send property updates to the server as a user types into an input-field --}}
              {{-- wire:model.debounce -> You can customize this timing by appending .debounce.Xms --}}
              {{-- wire:model.blur -> By appending the .blur modifier, Livewire will only send network requests with property updates when a user clicks away
              from an input, or presses the tab key to move to the next input --}}
              {{-- wire:model.live -> if you want to run validation every time a select input is changed --}}
        </div>

        {{-- Table --}}
        <div class="flex flex-col mt-10">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <button class="flex items-center uppercase hover:underline"
                                            wire:click="sortBy('title')">
                                            Title
                                            @if($sortField === 'title')
                                            <svg class="w-3 h-3 ml-1 duration-200 @if($sortDirection === 'desc') rotate-180 @endif"
                                                fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd"
                                                    d="M16.707 10.293a1 1 0 010 1.414l-6 6a1 1 0 01-1.414 0l-6-6a1 1 0 111.414-1.414L9 14.586V3a1 1 0 012 0v11.586l4.293-4.293a1 1 0 011.414 0z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            @endif
                                        </button>
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <button class="flex items-center uppercase hover:underline"
                                            wire:click="sortBy('created_at')">
                                            Created At
                                            @if($sortField === 'created_at')
                                            <svg class="w-3 h-3 ml-1 duration-200 @if($sortDirection === 'desc') rotate-180 @endif"
                                                fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd"
                                                    d="M16.707 10.293a1 1 0 010 1.414l-6 6a1 1 0 01-1.414 0l-6-6a1 1 0 111.414-1.414L9 14.586V3a1 1 0 012 0v11.586l4.293-4.293a1 1 0 011.414 0z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            @endif
                                        </button>
                                    </th>
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Edit</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($articles as $article)
                                <tr wire:key="{{ 'article-'.$article->id }}">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <img class="h-10 w-10 rounded-full" src="{{ $article->imageUrl() }}"
                                                    alt="{{ $article->title }}" />
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    <a href="{{route('articles.show', $article)}}">
                                                        {{ $article->title }}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-600">{{ $article->created_at->diffForHumans() }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-between items-center">
                                            <a href="{{route('articles.edit', $article)}}"
                                                class="text-indigo-500 hover:text-indigo-900">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                                    </path>
                                                </svg>
                                            </a>
                                            <livewire:article-delete-modal wire:key="{{'article-delete-button-'.$article->id}}"
                                                :article="$article">
                                                <button
                                                    wire:click="$dispatch('confirmArticleDeletion', { article: {{ $article }} })"
                                                    class="text-red-500 hover:text-red-900">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </livewire:article-delete-modal>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="px-4 py-3 bg-gray-50 border-t">
                            {{ $articles->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Table --}}
    </div>
</div>
