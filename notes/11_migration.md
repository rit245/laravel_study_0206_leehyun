마이그레이션은 DB를 생성한 뒤
테이블 및 컬럼 생성하는 화면을 만드는 과정을 동기화합니다.

이렇게 하는 이유는 로컬에서 협업할 때 같은 테이블 컬럼으로 활용하고 있는지를 체크가 가능합니다.

### 수동 마이그레이션 문제

* 공유가 잘 안됨
* 배포 문제 (같은 Database Schema 문제)
* 이력관리가 안됨

누가 언제 어떤 이유로, 왜 바꿨는지가 추적되지 않음

그렇기 때문에 데이터베이스는 코드로 관리가 되어야 합니다. 물론 상용서버는 워낙 위험하니 프로그램으로 실행한다기 보다 데이터베이스 관리자가 수동으로 직접  만들어야 할 수 있지만 

### 예전 방식 사용법

```angular2html
sail mysql -uroot -p
```

## 라라벨에서는 어떻게 사용하는가

https://laravel.com/docs/10.x/migrations

### sail 재시작

```angular2html
sqil down
sqil up -d
```

```angular2html
npm run dev
```

### 마이그레이션 생성하기


```angular2html
sail artisan make:migration CreateArticlesTable
```

database/migrations/ 경로에 파일이 추가되는 것을 확인할 수 있습니다.


foreignId 는 외래 키를 생성하여 참조 무결성을 만들 수 있게 됩니다.


```angular2html
sail artisan migrate
```

이제 롤백하는 방법도 알아야 합니다.

```angular2html
sail artisan migrate:rollback
```

up 과 down 이 있는데요
롤백할 때 down 이 돌게 됩니다

강13 20:00. 만약 예상치 못하게 articles 테이블을 삭제했을 경우
down 코드를 그냥 주석처리해버리고 롤백 > 마이그레이션을 올린 뒤 주석 해제를 한 뒤 rollback 을 하면 됩니다

```
    public function down(): void
    {
        Schema::dropIfExists('articles');

        // 강13 20:00. 만약 예상치 못하게 articles 테이블을 삭제했을 경우
        // down 코드를 그냥 주석처리해버리고 롤백 > 마이그레이션을 올린 뒤 주석 해제를 한 뒤 rollback 을 하면 됩니다
        // Schema:: drop('articles');
    }
```

