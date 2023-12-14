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
        Schema::create('del_reasons', function (Blueprint $table) {
            $table->id();
            $table->integer('u_id');
            $table->char('del_flg',1);  
            $table->string('del_self_msg',50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('del_reasons');
    }
};
