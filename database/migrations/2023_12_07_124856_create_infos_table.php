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
            $table->string('title', 200);
            $table->string('content', 2000);
            $table->string('img1', 100);
            $table->string('img2', 100);
            $table->string('img3', 100);
            $table->integer('hits');
            $table->char('ns_flg', 10);
            $table->string('states_name', 10);
            $table->char('main_flg', 5);
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
