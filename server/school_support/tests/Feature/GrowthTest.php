<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Growth;
use App\Models\Child;
use App\Models\GradeClass;
use App\Models\GradeClassHistory;

class GrowthTest extends TestCase
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

        $child = Child::factory()->create();
        $gradeClass = GradeClass::factory()->create();
        GradeClassHistory::factory()->create([
            'child_id' => $child->id,
            'grade_class_id' => $gradeClass->id,
        ]);

        $response = $this->get(route('growths.index'));

        $response->assertStatus(200);
        $response->assertInertia(function ($page) use ($child, $gradeClass) {
            $page->component('Growth/Index')
                ->has('children', 1)
                ->where('children.0.id', $child->id)
                ->where('children.0.grade_name', $gradeClass->grade_name)
                ->where('children.0.class_name', $gradeClass->class_name);
        });
    }
}
