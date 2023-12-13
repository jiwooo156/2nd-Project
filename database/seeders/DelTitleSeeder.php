<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Del_Title;

class DelTitleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Del_Title::create([
            'del_flg' => '0',
            'del_msg' => '기타(직접입력)',
        ]);
        Del_Title::create([
            'del_flg' => '1',
            'del_msg' => '서비스가 마음에 안듬',
        ]);
        Del_Title::create([
            'del_flg' => '2',
            'del_msg' => '원하는 정보가 없음',
        ]);
        Del_Title::create([
            'del_flg' => '3',
            'del_msg' => '불건전한 내용',
        ]);
    }
}
