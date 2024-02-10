
sail artisan make:test ArticleControllerTest




### 테스트 진행하기

sail artisan test --filter=ArticleControllerTest


### 주석 달기

    /**
     * @test
     */

위와 같이 주석을 달아야 합니다


### 메서드 예제 정리

        // 'GET' 요청을 '/your-endpoint'에 보내고 응답을 검증합니다.
        $response = $this->get('/your-endpoint');

        // assertStatus(200): HTTP 응답 코드가 200인지 확인합니다. 200은 요청이 성공적이라는 것을 의미합니다.
        $response->assertStatus(200);

        // assertSee('글쓰기'): 응답 본문에 '글쓰기'라는 텍스트가 포함되어 있는지 검사합니다.
        // 이는 특정 페이지나 API 응답에 예상 텍스트가 포함되어 있는지 확인할 때 유용합니다.
        $response->assertSee('글쓰기');

        // assertRedirect(): 응답이 리다이렉션을 포함하는지 검사합니다.
        // 이 메서드는 주로 사용자가 특정 조건을 만족하지 않았을 때 리다이렉션되는지 확인하는데 사용됩니다.
        // 예를 들어, 인증되지 않은 사용자가 인증이 필요한 페이지에 접근하려 할 때 리다이렉트 되는지 확인할 수 있습니다.
        // 특정 경로로의 리다이렉션을 확인하려면 assertRedirect('/expected-path')와 같이 사용할 수 있습니다.
        $response->assertRedirect();
        


### 가상 데이터 추가하기

```angular2html
sail artisan make:factory ArticleFactory
```
가상 데이터를 추가하기 위해 공장(팩토리) 를 만듭니다
