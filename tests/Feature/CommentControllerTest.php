<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class CommentControllerTest extends TestCase
{
    use RefreshDatabase; /* 테스트 끝나면 트랜잭션을 걸어서 데이터 정리 */

    /**
     * @test
     */
    public function 댓글을_작성할_수_있다(): void
    {

        $user = User::factory()->create();

        $article = Article::factory()->create();

        $payload = ['article_id' => $article->id, 'body' => 'hello'];

        $this->actingAs($user)
            ->post(route('comments.store'), $payload)
            ->assertStatus(302)
            ->assertRedirectToRoute('articles.show', ['article' => $article->id]);

        $this->assertDatabaseHas('comments', $payload);
    }

}
