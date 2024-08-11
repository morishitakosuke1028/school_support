<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\GradeClass;
use App\Models\Homework;

class HomeworkTest extends TestCase
{
    use RefreshDatabase;
    /**
     * テストユーザーの作成
     *
     * @return \App\Models\User
     */
    protected function createUser()
    {
        return User::factory()->create([
            'role' => 1,
        ]);
    }

    /**
     * Index メソッドのテスト
     *
     * @return void
     */
    public function test_index()
    {
        $user = $this->createUser();
        $this->actingAs($user);

        GradeClass::factory()->count(3)->create();

        $response = $this->actingAs($user)->get(route('homeworks.index'));

        $response->assertStatus(200);
        $response->assertInertia(function ($page) {
            $page->component('Homework/Index')
                ->has('gradeClasses.data', 3)
                ->where('currentUserRole', true);
        });
    }
}
