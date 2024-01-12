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
        Schema::table('infos', function (Blueprint $table) {
            $table->char('couple_flg', 1)->default("0")->after('end_at');
            $table->char('friend_flg', 1)->default("0")->after('couple_flg');
            $table->char('family_flg', 1)->default("0")->after('friend_flg');
            $table->char('parking_flg', 1)->default("0")->after('family_flg');
            $table->string('fee', 500)->default("없음")->after('parking_flg');
            $table->string('time', 500)->default("없음")->after('fee');
            $table->string('holiday', 50)->default("연중무휴")->after('time');
            $table->string('tel', 30)->default("없음")->after('holyday');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
