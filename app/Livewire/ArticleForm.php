<?php

namespace App\Livewire;

use App\Models\Article;
use Livewire\Component;

class ArticleForm extends Component
{

    public $title;
    public $content;

    public function render()
    {
        return view('livewire.article-form');
    }

    public function save() 
    {
      $data = $this->validate([
        'title' => ['required'],
        'content' => ['required']
      ]);

      Article::create($data);

      session()->flash('status',__('Article created.') );

      // $this->reset();

      $this->redirectRoute('articles.index');
    }
}
