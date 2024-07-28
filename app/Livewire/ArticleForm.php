<?php

namespace App\Livewire;

use App\Models\Article;
use Livewire\Component;

class ArticleForm extends Component
{

    public $title;
    public $content;

    protected $rules = [
      'title' => ['required', 'min:4'],
      'content' => ['required']
    ];

    /* protected $messages = [
      'title.required' => 'You need to add a :attribute'
    ];
    protected $validationAttributes = [
      'title' => 'article title'
    ]; */

    public function render()
    {
        return view('livewire.article-form');
    }

    public function save() 
    {

      Article::create($this->validate());

      session()->flash('status',__('Article created.') );

      // $this->reset();

      $this->redirectRoute('articles.index');
    }

    public function updated($property)
    {
      $this->validateOnly($property);
    }
}
