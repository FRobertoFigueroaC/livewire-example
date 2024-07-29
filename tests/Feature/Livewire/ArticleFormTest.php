<?php

namespace Tests\Feature\Livewire;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class ArticleFormTest extends TestCase
{
  use RefreshDatabase;
    public $title = 'New title';
    public $content = 'New content';
    public $slug = 'new-title';

    public $updated_title = 'Updated title';
    public $updated_content = 'Updated content';
    public $updated_slug = 'updated-slug';
    
    /** @test */
    public function can_create_new_article()
    {
      $user = User::factory()->create();

      Livewire::actingAs($user)
        ->test('article-form')
        ->set('article.title', $this->title)
        ->set('article.slug', $this->slug)
        ->set('article.content', $this->content)
        ->call('save')
        ->assertSessionHas('status')
        ->assertRedirect(route('articles.index'))
      ;

      $this->assertDatabaseHas('articles', [
        'title' => $this->title,
        'content' => $this->content,
        'slug' => $this->slug,
        'user_id' => $user->id
      ]);
    }
    /** @test */
    public function title_is_required()
    {
      Livewire::test('article-form')
        ->set('article.content', $this->content)
        ->call('save')
        ->assertHasErrors([
          'article.title' => 'required'
        ])
        ->assertSeeHtml(__('validation.required', ['attribute' => 'title']))
        ;

    }

    /** @test */
    public function slug_is_required()
    {

      Livewire::test('article-form')
        ->set('article.title', $this->title)
        ->set('article.content', $this->content)
        ->set('article.slug', null)
        ->call('save')
        ->assertHasErrors([
          'article.slug' => 'required'
        ])
        ->assertSeeHtml(__('validation.required', ['attribute' => 'slug']))
        ;

    }

    /** @test */
    public function slug_must_be_unique()
    {
      $article = Article::factory()->create();

      $user = User::factory()->create();

      Livewire::actingAs($user)
        ->test('article-form')
        ->set('article.title', $this->title)
        ->set('article.slug', $article->slug)
        ->set('article.content', $this->content)
        ->call('save')
        ->assertHasErrors([
          'article.slug' => 'unique'
        ])
        ->assertSeeHtml(__('validation.unique', ['attribute' => 'slug']))
        ;
    }

    /** @test */
    public function unique_rule_must_be_ignored_when_updating_the_same_register()
    {
      $article = Article::factory()->create();

      $user = User::factory()->create();

      Livewire::actingAs($user)
        ->test('article-form', ['article' => $article])
        ->set('article.title', $this->updated_title)
        ->set('article.slug', $article->slug)
        ->set('article.content', $this->updated_content)
        ->call('save')
        ->assertHasNoErrors(['article.slug' => 'unique'])
        ->assertSessionHas('status')
        ->assertRedirect(route('articles.index'))
        ;
        $this->assertDatabaseCount('articles', 1);

        $this->assertDatabaseHas('articles', [
          'title' => $this->updated_title,
          'content' => $this->updated_content,
          'slug' => $article->slug
        ]);
    }

    /** @test */
    public function title_must_be_at_leat_4_caharacters()
    {


      Livewire::test('article-form')
        ->set('article.title', 'New')
        ->set('article.content', $this->content)
        ->call('save')
        ->assertHasErrors([
          'article.title' => 'min'
        ])
        ->assertSeeHtml(__('validation.min.string', ['attribute' => 'title', 'min' => 4]))
        ;

    }
    /** @test */
    public function content_is_required()
    {

      Livewire::test('article-form')
        ->set('article.title', $this->title)
        ->call('save')
        ->assertHasErrors([
          'article.content' => 'required'
        ])
        ->assertSeeHtml(__('validation.required', ['attribute' => 'content']))
        ;

    }

    /** @test */
    public function real_time_validation_works_for_title()
    {
      Livewire::test('article-form')
        ->set('article.title', '')
        ->assertHasErrors([
          'article.title' => 'required'
        ])
        ->set('article.title', 'New')
        ->assertHasErrors([
          'article.title' => 'min'
        ])
        ->set('article.title', 'New Article')
        ->assertHasNoErrors('article.title')
        ;
    }

    /** @test */
    public function real_time_validation_works_for_content()
    {
      Livewire::test('article-form')
        ->set('article.content', '')
        ->assertHasErrors([
          'article.content' => 'required'
        ])
        ->set('article.content', 'New Article')
        ->assertHasNoErrors('article.content')
        ;
    }

    /** @test */
    public function can_update_articles()
    {
      $article = Article::factory()->create();

      $user = User::factory()->create();

      Livewire::actingAs($user)
        ->test('article-form', ['article' => $article])
        ->assertSet('article.title', $article->title)
        ->assertSet('article.slug', $article->slug)
        ->assertSet('article.content', $article->content)
        ->set('article.title', $this->updated_title)
        ->set('article.slug', $this->updated_slug)
        ->set('article.content', $this->updated_content)
        ->call('save')
        ->assertSessionHas('status')
        ->assertRedirect(route('articles.index'))
      ;

      $this->assertDatabaseCount('articles', 1);

      $this->assertDatabaseHas('articles', [
        'title' => $this->updated_title,
        'content' => $this->updated_content,
        'slug' => $this->updated_slug
      ]);
    }

    /** @test */
    public function article_form_renders_properly()
    {
      $user = User::factory()->create();

      $this->actingAs($user)->get(route('articles.create'))
        ->assertSeeLivewire('article-form');

      $article = Article::factory()->create();

      $this->actingAs($user)->get(route('articles.edit', $article))
        ->assertSeeLivewire('article-form');
    }

    /** @test */
    public function blade_template_is_wired_properly()
    {
        Livewire::test('article-form')
        ->assertSeeHtml('wire:submit.prevent="save"')
        ->assertSeeHtml('wire:model.live.debounce.250ms="article.title"')
        ->assertSeeHtml('wire:model.live.debounce.250ms="article.slug"')
        ->assertSeeHtml('wire:model.live.debounce.250ms="article.content"')
        ;
    }

    /** @test */
    public function slug_is_generated_automatically()
    {
      Livewire::test('article-form')
        ->set('article.title', $this->title)
        ->assertSet('article.slug', $this->slug)
        ;
    }

    /** @test */
    public function slug_must_be_alpha_dash()
    {
      Livewire::test('article-form')
        ->set('article.slug', 'test*&^')
        ->assertHasErrors([
          'article.slug' => 'alpha_dash'
        ])
        ->assertSeeHtml(__('validation.alpha_dash', ['attribute' => 'slug']));
        ;
    }

    /** @test */
    public function guest_cannot_create_or_update_articles()
    {
      // $this->withoutExceptionHandling();
      $this->get(route('articles.create'))
        ->assertRedirect('login');

      $article = Article::factory()->create();
      
      $this->get(route('articles.edit', $article))
        ->assertRedirect('login');
    }


}
