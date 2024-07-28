<div>
    
  <form wire:submit.prevent="save">
    <label for="title">
      Title:
      <input wire:model.live.debounce.250ms="title"
            placeholder="Title"
            type="text"
            id="title">
      @error('title')
        <div>{{$message}}</div>
      @enderror
    </label>
    
   
    
    <label for="content">
      Content:
      <textarea wire:model.live.debounce.250ms="content"
        id="content"
        placeholder="Content">
      </textarea>
      @error('content')
          <div>{{$message}}</div>
      @enderror
    </label>
    

    <button type="submit">Save</button>
  </form>
</div>
