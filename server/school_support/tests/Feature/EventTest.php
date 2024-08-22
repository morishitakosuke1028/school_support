<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Event;
use App\Models\GradeClass;
use Carbon\Carbon;

class EventTest extends TestCase
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

    public function test_index()
    {
        $user = $this->createUser();
        $this->actingAs($user);

        // 外部キー制約を無効にする
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // データベースの状態をリセット
        GradeClass::truncate();
        Event::truncate();

        // 外部キー制約を有効に戻す
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 必要なテストデータを作成
        $gradeClasses = GradeClass::factory()->count(2)->create();

        Event::factory()->count(3)->create([
            'grade_class_id' => $gradeClasses->random()->id,
        ]);

        $response = $this->get(route('events.index'));

        $response->assertStatus(200);
        $response->assertInertia(function ($page) {
            $page->component('Event/Index')
                ->has('events', 3)
                ->has('gradeClasses', 2)
                ->where('currentUserRole', true);
        });
    }
}
