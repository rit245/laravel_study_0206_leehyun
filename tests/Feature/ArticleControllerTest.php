<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class ArticleControllerTest extends TestCase
{
    use RefreshDatabase; /* 테스트 끝나면 트랜잭션을 걸어서 데이터 정리 */

    /**
     * @test
     */
    public function 글쓰기_화면을_볼_수_있다(): void
    {
        $this->get(route('articles.create'))
            ->assertStatus(200)
            ->assertSee('글쓰기');
    }

    /**
     * @test
     */
    public function 글을_작성할수_있다(): void{
        // database/factories/UserFactory.php 참조

//        첫번째 방법
//        $user = User::factory()->create();
//        $this->actingAs($user)
//            ->post(
//                route('articles.store'),
//            [
//                'body'=>'test article'
//            ])
//        ->assertRedirect(route('articles.index')); /* 리디렉션 되는지 체크 */
//

//      두번째 방법
        $testData = [
            'body' => 'test article'
        ];

        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('articles.store'),$testData)
            ->assertRedirect(route('articles.index')); /* 리디렉션 되는지 체크 */

        $this->assertDatabaseHas('articles', $testData);

    }

    /**
     * @test
     */
    public function 글_목록을_확인할_수_있다(): void{

        /* 글 생성이 초단위로 이루어지기 때문에 간격을 두고 출력 */

        $now = Carbon::now();
        $afterOneSecond = (clone $now)->addSecond();

        $article1 = Article::factory()->create(
            ['created_at' => $now]
        );
        $article2 = Article::factory()->create(
            ['created_at' => $afterOneSecond]
        );

        $this->get(route('articles.index'))
            ->assertSee($article1->body)
            ->assertSee($article2->body)
            ->assertSeeInOrder([ /* 2가 먼저 보이고 1이 보임 */
               $article2->body,
               $article1->body
           ]);
    }

    /**
     * @test
     */
    public function 개별_글을_조회할_수_있다(): void
    {
        $article = Article::factory()->create();

        $this->get(route('articles.show', ['article'=>$article->id]))
            ->assertSuccessful()
            ->assertSee($article->body);
    }

    /**
     * @test
     */
    public function 글수정_화면을_볼_수_있다(): void
    {
        $article = Article::factory()->create();
        $this->get(route('articles.edit', ['article'=>$article->id]))
            ->assertStatus(200)
            ->assertSee('글 수정하기');
    }

    /**
     * @test
     */
    public function 글을_수정할_수_있다(): void
    {
        $payload = ['body' => '수정된 글'];
        $article = Article::factory()->create();
        $this->patch(route('articles.update', ['article'=>$article->id]),
        $payload)
            ->assertRedirect(route('articles.index'));

        $this->assertDatabaseHas('articles', $payload);

        $this->assertEquals($payload['body'], $article->refresh()->body);
    }

    /**
     * @test
     */
    public function 글을_삭제할_수_있다():void
    {
        $article = Article::factory()->create();

        $this->delete(route('articles.delete', ['article'=>$article->id]))
        ->assertRedirect(route('articles.index'));

        $this->assertDatabaseMissing('articles', ['id'=>$article->id]);
    }
}
