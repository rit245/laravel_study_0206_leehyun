
권한 확인
https://laravel.kr/docs/9.x/authorization

* Authorizing Actions Using Policies
* Via The User Model
* Via Controller Helpers
* Via Middleware
* Via Blade Templates
* Supplying Additional Context


```
sail artisan make:policy ArticlePolicy --model=Article
```
Article 모델 연결된 상태


```
sail artisan make:policy ArticlePolicy
```
이렇게 만들면 모델 연결이 안되어있는 상태로 만들어짐


