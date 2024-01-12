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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email', 50);
            $table->string('password',);
            $table->string('name', 10);
            $table->char('gender', 1);
            $table->string('phone', 11);
            $table->char('birthdate', 15);
            $table->string('nick', 8);
            $table->timestamps();
            $table->softDeletes();  
            // $table->char('del_flg', 1)->nullable();
            // $table->string('del_msg', 50)->nullable();
            // 1213 최정훈 수정  테이블 추가
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
