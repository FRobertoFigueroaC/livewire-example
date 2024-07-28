<?php

use App\Livewire\ArticleForm;
use App\Livewire\Articles;
use Illuminate\Support\Facades\Route;

Route::get('/',Articles::class)
  ->name('articles.index');

Route::get('/blog/create',ArticleForm::class)
  ->name('articles.create');
