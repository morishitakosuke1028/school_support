<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Subject;

class SubjectTest extends TestCase
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

        Subject::query()->delete();

        // テストデータを作成
        Subject::factory()->count(3)->create();

        $response = $this->get(route('subjects.index'));

        $response->assertStatus(200);
        $response->assertInertia(function ($page) {
            $page->component('Subject/Index')
                ->where('currentUserRole', true);
        });
    }
}
