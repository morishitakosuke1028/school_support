<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Child;
use App\Models\GradeClass;
use App\Models\User;
use Carbon\Carbon;


class DailyTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the index method for displaying children and filtering by grade and class names.
     *
     * @return void
     */
    public function test_index_displays_children_with_filters()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $gradeClassA = GradeClass::factory()->create(['grade_name' => 'Grade 1', 'class_name' => 'A']);
        $gradeClassB = GradeClass::factory()->create(['grade_name' => 'Grade 2', 'class_name' => 'B']);

        $child1 = Child::factory()->create(['name' => 'John', 'kana' => 'じょん']);
        $child1->gradeClassHistories()->create(['grade_class_id' => $gradeClassA->id]);

        $child2 = Child::factory()->create(['name' => 'Jane', 'kana' => 'じぇいん']);
        $child2->gradeClassHistories()->create(['grade_class_id' => $gradeClassB->id]);

        $response = $this->get(route('attendance.index', [
            'gradeNames' => 'Grade 1',
            'classNames' => 'A',
            'childName' => 'John',
        ]));

        $response->assertStatus(200);

        $response->assertInertia(fn ($page) =>
            $page->component('Attendance/Index')
                ->has('children', 1)
                ->where('children.0.name', 'John')
                ->where('children.0.kana', 'じょん')
                ->where('gradeClasses.0.grade_name', 'Grade 1')
        );
    }

    /**
     * Test index method when no matching children are found.
     *
     * @return void
     */
    public function test_index_displays_default_children_if_no_matches_found()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $child = Child::factory()->create(['name' => 'Unfiltered Child']);
        $gradeClass = GradeClass::factory()->create();
        $child->gradeClassHistories()->create(['grade_class_id' => $gradeClass->id]);

        $response = $this->get(route('attendance.index', [
            'gradeNames' => 'Non-Existent Grade',
        ]));

        $response->assertStatus(200);

        $response->assertInertia(fn ($page) =>
            $page->component('Attendance/Index')
                ->has('children', 1)
                ->where('children.0.name', 'Unfiltered Child')
                ->where('children.0.dailies.attendance_status', null)
        );
    }
}
