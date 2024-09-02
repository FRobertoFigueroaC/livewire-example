<?php

use App\Livewire\ArticleForm;
use App\Livewire\ArticleShow;
use App\Livewire\ArticlesTable;
use Illuminate\Support\Facades\Route;



Route::get('/blog/create',ArticleForm::class)
  ->name('articles.create')
  ->middleware('auth');

Route::get('/blog/{article:id}/edit',ArticleForm::class)
  ->name('articles.edit')
  ->middleware('auth');

Route::get('/', ArticlesTable::class)
  ->name('articles.index');

Route::get('/blog/{article}',ArticleShow::class)
  ->name('articles.show');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
