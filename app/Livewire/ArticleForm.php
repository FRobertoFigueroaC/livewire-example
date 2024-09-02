<?php

namespace App\Livewire;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class ArticleForm extends Component
{
    use WithFileUploads;

    public Article $article;
    public $category;
    public $image;

    public $showCategoryModal = false;

    protected function rules (){
      return [
      'image' => [
                Rule::requiredIf(!$this->article->image),
                Rule::when($this->image, ['image', 'max:2048'])
      ],
      'article.title' => ['required', 'min:4'],
      'article.content' => ['required'],
      'article.category_id' => ['required'],
      'article.slug' => [
        'required',
        'alpha_dash',
        Rule::unique('articles', 'slug')->ignore($this->article->id)
        // 'unique:articles,slug,' .$this->article->id
        ],
        'category.name' => [],
        'category.slug' => []
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

      // Upload file
      if($this->image) {
        $this->article->image = $this->uploadImage();
      }

      // Auth::user()->articles()->save($this->article);
      $this->article->user_id = auth()->id();
      $this->article->save();
      session()->flash('status', __('Article saved.') );
      // $this->reset();
      $this->redirectRoute('articles.index');
    }

    public function uploadImage(){

        if ($oldImage = $this->article->image) {
            Storage::disk('public')->delete($oldImage);
        }
        return $this->image->store('/', 'public');
    }

    public function render()
    {
        return view('livewire.article-form', [
            'categories' => Category::pluck('name', 'id')
        ])->layout('layouts.app');
    }

    public function openCategoryForm()
    {
        $this->showCategoryModal = true;
        $this->category = new Category();
    }
    public function updatedCategoryName($name)
    {
        $this->category->slug = Str::slug($name);
    }
    public function closeCategoryForm()
    {
        $this->showCategoryModal = false;
        $this->clearValidation('category.*');
    }

    public function saveCategory()
    {
        $this->validate([
            'category.name' => [
                Rule::requiredIf($this->category instanceof Category),
                Rule::unique('categories', 'name'),
            ],
            'category.slug' => [
                Rule::requiredIf($this->category instanceof Category),
                Rule::unique('categories', 'slug'),
            ]
        ]);
        $this->category->save();
        $this->article->category_id = $this->category->id;
        $this->closeCategoryForm();
    }


}
