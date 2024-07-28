<div>
    
  <form wire:submit.prevent="save">
    <label for="title">
      Title:
      <input wire:model="title"
            placeholder="Title"
            type="text"
            id="title">
      @error('title')
        <div>{{$message}}</div>
      @enderror
    </label>
    
   
    
    <label for="content">
      Content:
      <textarea wire:model="content"
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
