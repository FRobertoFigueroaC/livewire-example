<div>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{__('New Article')}}
    </h2>
  </x-slot>

  <div>
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
      <x-form-section submit="save">
        <x-slot name="title">
         {{__('New Article')}}
        </x-slot>
        <x-slot name="description">
         {{__('Here you can create and update your articles')}}
        </x-slot>


        <x-slot name="form">
            {{-- Image --}}
            <div class="col-span-6 sm:col-span-4">
                <x-select-image wire:model="image" :image="$image" :existing="$article->image"/>
                <x-input-error for="image" class="mt-2" />
            </div>

            {{-- Title --}}
            <div class="col-span-6 sm:col-span-4">
                <x-label for="title" value="{{ __('Title') }}"/>
                <x-input id="title" type="text"
                class="mt-1 block w-full"
                wire:model.live.debounce.250ms="article.title"/>
                <x-input-error for="article.title" class="mt-2" />
            </div>

            {{-- Slug --}}
            <div class="col-span-6 sm:col-span-4">
                <x-label for="slug" value="{{ __('URL Friendly') }}" />

                <x-input wire:model.live.debounce.250ms="article.slug"
                class="mt-1 block w-full"
                type="text"
                id="slug"/>
                <x-input-error for="article.slug" class="mt-2" />
            </div>

            {{-- Categroy --}}
            <div class="col-span-6 sm:col-span-4">
                <x-label for="category_id" value="{{ __('Category') }}" />
                <div class="flex mt-1 spaxe-x-2">
                    <x-select wire:model.live.debounce.250ms="article.category_id" :options="$categories"
                        :placeholder=" __('Select Category')" id="category_id" class="block w-full">

                    </x-select>
                    <x-secondary-button class="!p-2.5" wire:click="openCategoryForm">
                        <svg class="w-5 h-5"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                            class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    </x-secondary-button>
                </div>
                <x-input-error for="article.category_id" class="mt-2" />
            </div>
            {{-- Content --}}
          <div class="col-span-6 sm:col-span-4">
            <x-label for="content" value="{{ __('Content') }}" />

            <x-html-editor wire:model.live.debounce.250ms="article.content" class="mt-1 block w-full" id="content"/>

            <x-input-error for="article.content" class="mt-2" />

          </div>

          <x-slot name="actions">
            <x-button>
              {{ __('Save') }}
            </x-button>
          </x-slot>

        </x-slot>
      </x-form-section>
    </div>
  </div>

  {{-- Modal --}}
  <x-modal wire:model.live.debounce.250ms="showCategoryModal">
    <form action="#">
        <div class="px-6 py-4">
            <pre>{{$category}}</pre>
            <div class="text-lg font-medium text-gray-900">
                {{__('New Category')}}
            </div>

            @if ($category)
                <div class="mt-4 space-y-3 text-sm text-gray-600">
                    {{-- Name --}}
                    <div class="col-span-6 sm:col-span-4">
                        <x-label for="categoryName" value="{{ __('Name') }}" />
                        <x-input id="categoryName" type="text" class="mt-1 block w-full" wire:model.live.debounce.250ms="category.name" />
                        <x-input-error for="category.name" class="mt-2" />
                    </div>

                    {{-- Slug --}}
                    <div class="col-span-6 sm:col-span-4">
                        <x-label for="categorySlug" value="{{ __('URL Friendly') }}" />

                        <x-input wire:model.live.debounce.250ms="category.slug" class="mt-1 block w-full" type="text" id="categorySlug" />
                        <x-input-error for="category.slug" class="mt-2" />
                    </div>
                </div>
            @endif

        </div>

        <div class="flex flex-row justify-end px-6 py-4 bg-gray-100 text-end">
           <x-secondary-button wire:click="closeCategoryForm">
                Close
            </x-secondary-button>
        </div>
    </form>
  </x-modal>
  {{-- Modal --}}

</div>
