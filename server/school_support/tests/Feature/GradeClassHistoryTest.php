<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Child;
use App\Models\GradeClass;
use App\Models\GradeClassHistory;
use App\Models\User;

class GradeClassHistoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_displays_grade_class_histories()
    {
        $user = User::factory()->create(['role' => 1]);
        $this->actingAs($user);

        $gradeClass = GradeClass::factory()->create();
        $child = Child::factory()->create();
        $gradeClassHistory = GradeClassHistory::factory()->create([
            'grade_class_id' => $gradeClass->id,
            'child_id' => $child->id,
            'user_id' => $user->id,
        ]);

        $response = $this->get(route('gradeClassHistories.index'));

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) =>
            $page->component('GradeClassHistory/Index')
                ->has('gradeClassHistories', 1)
                ->has('gradeClasses', 1)
                ->has('children', 1)
                ->has('users', 1)
        );
    }
}
