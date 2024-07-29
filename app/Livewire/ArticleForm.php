<?php

namespace App\Livewire;

use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Livewire\Component;

class ArticleForm extends Component
{

    public Article $article;

    protected function rules (){
      return [
      'article.title' => ['required', 'min:4'],
      'article.content' => ['required'],
      'article.slug' => [
        'required',
        'alpha_dash',
        Rule::unique('articles', 'slug')->ignore($this->article->id)
        // 'unique:articles,slug,' .$this->article->id
        ],
      ];
    }

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

    public function updatedArticleTitle($title)
    {
      // $this->article->slug = implode("-", explode(" ", strtolower($title)));
      $this->article->slug = Str::slug($title);
    }

    public function save() 
    {
      $this->validate();
      // Auth::user()->articles()->save($this->article);
      $this->article->user_id = auth()->id();
      $this->article->save();
      session()->flash('status', __('Article saved.') );
      // $this->reset();
      $this->redirectRoute('articles.index');
    }

    public function render()
    {
        return view('livewire.article-form');
    }

}
