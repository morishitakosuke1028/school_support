<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\GradeClass;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GradeClassTest extends TestCase
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
        Auth::login($user);

        GradeClass::factory()->count(3)->create();

        $response = $this->actingAs($user)->get(route('gradeClasses.index'));

        $response->assertStatus(200);
        $response->assertInertia(function ($page) {
            $page->component('GradeClass/Index')
                ->has('gradeClasses.data', 3)
                ->where('currentUserRole', true);
        });
    }

    /**
     * Create メソッドのテスト
     *
     * @return void
     */
    public function test_create()
    {
        $user = $this->createUser();
        Auth::login($user);

        $response = $this->actingAs($user)->get(route('gradeClasses.create'));

        $response->assertStatus(200);
        $response->assertInertia(function ($page) {
            $page->component('GradeClass/Create');
        });
    }
}
