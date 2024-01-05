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
        Schema::create('community', function (Blueprint $table) {
                $table->id();
                $table->integer('u_id');
                $table->string('title', 50);
                $table->string('content', 3000);
                $table->integer('hits')->default(0);
                $table->char('flg', 1);
                $table->char('category_flg', 1);
                $table->char('admin_flg', 1)->default(0);
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
        Schema::dropIfExists('community');
    }
};
