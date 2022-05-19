<?php

namespace Tests\Feature;

use App\Article;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    public function testIsLikedByNull()
    {
        // テストに必要なArticleモデルを「準備」
        $article = factory(Article::class)->create();

        // いいねがされてあるか「実行」
        $result = $article->isLikedBy(null);

        // レスポンスがfalseか「検証」
        $this->assertFalse($result);
    }

    public function testIsLikedByTheUser()
    {
        // テストに必要なArticleモデルとUserモデルを「準備」して
        // $articleと$userのidをlikesテーブルに新規登録
        $article = factory(Article::class)->create();
        $user = factory(User::class)->create();
        $article->likes()->attach($user);

        $result = $article->isLikedBy($user);

        $this->assertTrue($result);
    }

    public function testIsLikedByAnother()
    {
        $article = factory(Article::class)->create();
        $user = factory(User::class)->create();
        $another = factory(User::class)->create();
        $article->likes()->attach($another);

        $result = $article->isLikedBy($user);

        $this->assertFalse($result);
    }
}
