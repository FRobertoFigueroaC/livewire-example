<?php

namespace App\Livewire;

use App\Models\Article;
use Livewire\Component;

class ArticleForm extends Component
{

    public Article $article;

    protected $rules = [
      'article.title' => ['required', 'min:4'],
      'article.content' => ['required']
    ];

    /* protected $messages = [
      'title.required' => 'You need to add a :attribute'
    ];
    protected $validationAttributes = [
      'title' => 'article title'
    ]; */

    public function mount(Article $article)
    {
      $this->article = $article;
    }

    public function updated($property)
    {
      $this->validateOnly($property);
    }

    public function render()
    {
        return view('livewire.article-form');
    }

    public function save() 
    {
      
      $this->validate();
      $this->article->save();
      session()->flash('status',__('Article saved.') );
      // $this->reset();
      $this->redirectRoute('articles.index');
    }

}
