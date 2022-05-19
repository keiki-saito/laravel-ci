<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        $response = $this->get(route('articles.index')); // 引数に指定されたURLへGETリクエスト

        $response->assertStatus(200)  // 200であればテストに合格、200以外であればテストに不合格
            ->assertViewIs('articles.index');
    }

    public function testGuestCreate()
    {
        $response = $this->get(route('articles.create'));

        $response->assertRedirect(route('login'));
    }

    public function testAuthCreate()
    {
        // テストに必要なUserモデルを「準備」
        $user = factory(User::class)->create();

        // ログインして記事投稿画面にアクセスすることを「実行」
        $response = $this->actingAs($user)->get(route('articles.create'));

        // レスポンスを「検証」
        $response->assertStatus(200)->assertViewIs('articles.create'); // HTTPステータスコードが200かテスト
    }
}
