@php($id = $attributes->wire('model')->value)
<div x-data="{ focused: false }" class="relative">

    @if($image instanceof Livewire\Features\SupportFileUploads\TemporaryUploadedFile)
        <x-danger-button wire:click="$set('{{$id}}', null)" class="absolute bottom-2 right-2">
            {{__('Change Image')}}
        </x-danger-button>
        <img src="{{$image->temporaryUrl()}}" alt="Selected Image" class="border-2 rounded">
    @elseif ($existing)
        <label for="{{$id}}"
            class="absolute bottom-2 right-2 cursor-pointer inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 disabled:opacity-50 transition ease-in-out duration-150"
            :class="{'outline-none ring-2 ring-indigo-500 ring-offset-2 focus:bg-gray-700': focused}" >
            {{ __('Change Image') }}
        </label>
        <img src="{{Storage::disk('public')->url($existing)}}" alt="Selected Image" class="border-2 rounded">
    @else
        <div class="h-32 bg-gray-50 border-2 border-dashed rounded flex items-center justify-center">
            <label for="{{$id}}"
                class="cursor-pointer inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 disabled:opacity-50 transition ease-in-out duration-150"
                :class="{'outline-none ring-2 ring-indigo-500 ring-offset-2 focus:bg-gray-700': focused}" />
                {{ __('Select Image') }}
            </label>
        </div>
    @endif

    @unless ($image)

        <x-input x-on:focus="focused = true" x-on:blur="focused = false"
            :id="$id" type="file" class="sr-only" wire:model.live.debounce.250ms="{{$id}}" />
    @endunless
</div>
