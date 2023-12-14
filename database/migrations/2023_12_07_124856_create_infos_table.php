<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('infos', function (Blueprint $table) {
            $table->id();
            // $table->string('nick', 8);
            // 1213 최정훈 수정  관리자가 작성하는 영역이라 유저닉네임 필요x
            $table->string('title', 30);
            $table->string('content', 2000);
            $table->string('img1', 100);
            $table->string('img2', 100);
            $table->string('img3', 100);
            $table->integer('hits');
            $table->char('ns_flg', 1);
            $table->string('states_flg', 2);
            $table->char('main_flg', 1);
            $table->string('place', 50);
            $table->date('start_at');
            $table->date('end_at');
            $table->timestamps();
            $table->softDeletes();  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('infos');
    }
};
