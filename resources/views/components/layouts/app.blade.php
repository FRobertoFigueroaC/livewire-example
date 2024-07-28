<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel | Livewire</title>
        <style>
          label {
            display: block;
          }
        </style>
        @livewireStyles
    </head>
    <body>
      @if (session('status'))
        <div>
          {{session('status')}}
        </div>
      @endif
      {{ $slot }}

      @livewireScripts
    </body>
</html>
