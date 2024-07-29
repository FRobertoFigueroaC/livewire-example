<?php

use App\Livewire\ArticleForm;
use App\Livewire\Articles;
use App\Livewire\ArticleShow;
use Illuminate\Support\Facades\Route;



Route::get('/blog/create',ArticleForm::class)
  ->name('articles.create')
  ->middleware('auth');

Route::get('/blog/{article}/edit',ArticleForm::class)
  ->name('articles.edit')
  ->middleware('auth');

Route::get('/', Articles::class)
  ->name('articles.index');

Route::get('/blog/{article}',ArticleShow::class)
  ->name('articles.show');


Route::get('/login')->name('login');