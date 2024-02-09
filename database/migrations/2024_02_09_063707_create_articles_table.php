<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('body', 255);
            $table->foreignId('user_id')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');

        // 강13 20:00. 만약 예상치 못하게 articles 테이블을 삭제했을 경우
        // down 코드를 그냥 주석처리해버리고 롤백 > 마이그레이션을 올린 뒤 주석 해제를 한 뒤 rollback 을 하면 됩니다
        // Schema:: drop('articles');
    }
};
