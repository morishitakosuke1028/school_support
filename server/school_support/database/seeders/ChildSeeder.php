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
			DB::table('children')->insert([
				'name' => '園児　太郎',
				'kana' => '園児　たろう',
				'school_id' => '1',
				'gender' => '男',
				'zip' => '郵便番号',
				'address' => '京都府京都市右京区',
				'tel' => '08012345678',
				'birthday' => '2016/10/04',
				'admission_date' => '2023/04/01',
				'movein_date' => null,
				'graduation_date' => null,
				'pin_code' => '1234',
				'email' => 'child@example.com',
				'session_id' => 'child',
				'password' => Hash::make('password123'),
			]);
    }
}
