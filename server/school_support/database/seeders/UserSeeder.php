<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
			DB::table('users')->insert([
				'name' => 'admin teacher',
				'kana' => 'アドミンティーチャー',
				'school_id' => '1',
				'retirement_date' => null,
				'tel' => '09056781234',
				'role' => '1',
				'email' => 'admin@example.com',
				'session_id' => 'admin',
				'password' => Hash::make('password123'),
			]);
    }
}
