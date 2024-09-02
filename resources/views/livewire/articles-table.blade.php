<div>
    <h1>Listado de artículos</h1>

    <h4>Search {{ $search }}</h4>

    <a href="{{route('articles.create')}}">Create</a>
    <br>

      {{-- wire:model their values will be synchronized with the server's properties when the "Save" button is pressed --}}

      {{-- wire:model.live -> To send property updates to the server as a user types into an input-field --}}

      {{-- wire:model.debounce -> You can customize this timing by appending .debounce.Xms --}}

      {{-- wire:model.blur -> By appending the .blur modifier, Livewire will only send network requests with property updates when a user clicks away
      from an input, or presses the tab key to move to the next input --}}

      {{-- wire:model.live -> if you want to run validation every time a select input is changed --}}

      <input wire:model.live.debounce.350ms="search"
      type="text"
      placeholder="Categoría">




    <ul>
      @foreach ($articles as $article)
        <li>
          <a href="{{route('articles.show', $article)}}">
            {{$article->title}}
          </a>
          <a href="{{route('articles.edit', $article)}}">
            -> Edit
          </a>
        </li>
      @endforeach
    </ul>
</div>
