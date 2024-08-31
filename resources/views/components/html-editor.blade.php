@props(['disabled' => false])

<div 
    x-data="{ value:@entangle($attributes->wire('model'))}"
    x-on:trix-change="value = $event.target.value">
    <div wire:ignore>
    
        <trix-editor :value="value"
            {{ $disabled ? 'disabled' : '' }}
            {!! $attributes->whereDoesntStartWith('wire:model')->merge(['class'
            => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm']) !!}
            />
    </div>
</div>