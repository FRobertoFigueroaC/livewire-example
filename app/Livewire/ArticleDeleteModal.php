<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;

class ArticleDeleteModal extends Component
{

    public $article;
    public $showDeleteModal = false;

    protected $listeners = ['confirmArticleDeletion'];

    public function confirmArticleDeletion($article)
    {
        // dd($article);
        if ($this->article->id === $article['id']) {
            $this->showDeleteModal = true;
        }
    }

    public function delete()
    {
        Storage::disk('public')->delete($this->article->image);
        $this->article->delete();
        $this->redirect(route('articles.index'));
        session()->flash('status', __('Article deleted.'));
    }

    public function render()
    {
        return view('livewire.article-delete-modal');
    }
}
