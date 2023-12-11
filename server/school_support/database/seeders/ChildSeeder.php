<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ChildSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $commonData = [
            'school_id' => '1',
            'zip' => '郵便番号',
            'address' => '京都府京都市右京区',
            'movein_date' => null,
            'graduation_date' => null,
            'pin_code' => '1234',
            'password' => Hash::make('password123'),
        ];

        DB::table('children')->insert(array_merge([
            'name' => '生徒　太郎',
            'kana' => 'せいと　たろう',
            'gender' => '1',
            'tel' => '08012345678',
            'birthday' => '2016/10/04',
            'admission_date' => '2023/04/01',
            'email' => 'child@example.com',
            'session_id' => 'child1',
        ], $commonData));

        DB::table('children')->insert(array_merge([
            'name' => '生徒　次郎',
            'kana' => 'せいと　じろう',
            'gender' => '1',
            'tel' => '08012345679',
            'birthday' => '2016/11/04',
            'admission_date' => '2023/04/01',
            'email' => 'child2@example.com',
            'session_id' => 'child2',
        ], $commonData));

        DB::table('children')->insert(array_merge([
            'name' => '生徒　京子',
            'kana' => 'せいと　きょうこ',
            'gender' => '2',
            'tel' => '08012345689',
            'birthday' => '2016/12/04',
            'admission_date' => '2023/04/01',
            'email' => 'child3@example.com',
            'session_id' => 'child3',
        ], $commonData));

        DB::table('children')->insert(array_merge([
            'name' => '生徒　和子',
            'kana' => 'せいと　かずこ',
            'gender' => '2',
            'tel' => '08012345789',
            'birthday' => '2016/09/04',
            'admission_date' => '2023/04/01',
            'email' => 'child4@example.com',
            'session_id' => 'child4',
        ], $commonData));

        DB::table('children')->insert(array_merge([
            'name' => '比企谷　八幡',
            'kana' => 'ひきがや　はちまん',
            'gender' => '1',
            'tel' => '09056781234',
            'birthday' => '2014/08/08',
            'admission_date' => '2021/04/01',
            'email' => 'child5@example.com',
            'session_id' => 'child5',
        ], $commonData));

        DB::table('children')->insert(array_merge([
            'name' => '雪ノ下　雪乃',
            'kana' => 'ゆきのした　ゆきの',
            'gender' => '2',
            'tel' => '09056781235',
            'birthday' => '2015/01/03',
            'admission_date' => '2021/04/01',
            'email' => 'child6@example.com',
            'session_id' => 'child6',
        ], $commonData));

        DB::table('children')->insert(array_merge([
            'name' => '由比ヶ浜　結衣',
            'kana' => 'ゆいがはま　ゆい',
            'gender' => '2',
            'tel' => '09056781236',
            'birthday' => '2014/06/18',
            'admission_date' => '2021/04/01',
            'email' => 'child7@example.com',
            'session_id' => 'child7',
        ], $commonData));

        DB::table('children')->insert(array_merge([
            'name' => '川崎　沙希',
            'kana' => 'かわさき　さき',
            'gender' => '2',
            'tel' => '09056781237',
            'birthday' => '2014/10/26',
            'admission_date' => '2021/04/01',
            'email' => 'child8@example.com',
            'session_id' => 'child8',
        ], $commonData));

        DB::table('children')->insert(array_merge([
            'name' => '戸塚　彩加',
            'kana' => 'とつか　さいか',
            'gender' => '1',
            'tel' => '09056781238',
            'birthday' => '2014/05/09',
            'admission_date' => '2021/04/01',
            'email' => 'child9@example.com',
            'session_id' => 'child9',
        ], $commonData));

        DB::table('children')->insert(array_merge([
            'name' => '雪ノ下　陽乃',
            'kana' => 'ゆきのした  はるの',
            'gender' => '2',
            'tel' => '09056781239',
            'birthday' => '2011/07/07',
            'admission_date' => '2017/04/01',
            'email' => 'child10@example.com',
            'session_id' => 'child10',
        ], $commonData));

        DB::table('children')->insert(array_merge([
            'name' => '岡部　倫太郎',
            'kana' => 'おかべ　りんたろう',
            'gender' => '1',
            'tel' => '09016781234',
            'birthday' => '2012/12/14',
            'admission_date' => '2018/04/01',
            'email' => 'child11@example.com',
            'session_id' => 'child11',
        ], $commonData));

        DB::table('children')->insert(array_merge([
            'name' => '橋田　至',
            'kana' => 'はしだ　いたる',
            'gender' => '1',
            'tel' => '09026781234',
            'birthday' => '2012/05/19',
            'admission_date' => '2018/04/01',
            'email' => 'child12@example.com',
            'session_id' => 'child12',
        ], $commonData));

        DB::table('children')->insert(array_merge([
            'name' => '椎名　まゆり',
            'kana' => 'しいな　まゆり',
            'gender' => '2',
            'tel' => '09046781234',
            'birthday' => '2014/02/01',
            'admission_date' => '2019/04/01',
            'email' => 'child13@example.com',
            'session_id' => 'child13',
        ], $commonData));

        DB::table('children')->insert(array_merge([
            'name' => '牧瀬　紅莉栖',
            'kana' => 'まきせ　くりす',
            'gender' => '2',
            'tel' => '09056781234',
            'birthday' => '2013/07/25',
            'admission_date' => '2019/04/01',
            'email' => 'child14@example.com',
            'session_id' => 'child14',
        ], $commonData));

        DB::table('children')->insert(array_merge([
            'name' => '阿万音　鈴羽',
            'kana' => 'あまね　すずは',
            'gender' => '2',
            'tel' => '09066781234',
            'birthday' => '2013/09/27',
            'admission_date' => '2019/04/01',
            'email' => 'child15@example.com',
            'session_id' => 'child15',
        ], $commonData));
    }
}
