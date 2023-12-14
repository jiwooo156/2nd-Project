<?php

use Illuminate\Support\Facades\DB;
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
        Schema::create('authenticates', function (Blueprint $table) {
            $table->id();
            $table->string('email', 50);
            $table->string('auth_token', 256);
            $table->timestamp('auth_start')->default(DB::raw('now()'));
            $table->timestamp('auth_end')->default(DB::raw('DATE_ADD(now(), INTERVAL 5 MINUTE)'));
            $table->char('del_flg', 1)->default("0");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('authenticates');
    }
};
