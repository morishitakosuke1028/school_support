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

		public function test_store_saves_daily_attendance_data()
		{
				// Create user and log in
				$user = User::factory()->create();
				$this->actingAs($user);

				// Create a child and associate it with a grade class
				$child = Child::factory()->create();
				$gradeClass = GradeClass::factory()->create();
				$child->gradeClassHistories()->create(['grade_class_id' => $gradeClass->id]);

				// Mock daily attendance data with integer attendance_status and full date-time format for start_time and end_time
				$dailyData = [
						[
								'child_id' => $child->id,
								'attendance_status' => 1, // Assuming 1 represents "Present"
								'absence_reason' => '',
								'start_time' => now()->format('Y-m-d H:i'), // Full date-time format
								'end_time' => now()->addHours(8)->format('Y-m-d H:i'), // Full date-time format
								'admin_memo' => 'All good',
								'parent_memo' => 'Great day',
								'date_use' => now()->toDateString(),
								'entry_method' => 'Manual',
						]
				];

				// Send POST request to store method
				$response = $this->post(route('attendance.store'), [
						'dailies' => $dailyData
				]);

				// Assert that daily attendance was saved in the database with the correct format
				$this->assertDatabaseHas('dailies', [
						'child_id' => $child->id,
						'attendance_status' => 1,
						'start_time' => now()->format('Y-m-d H:i'),
						'end_time' => now()->addHours(8)->format('Y-m-d H:i'),
						'admin_memo' => 'All good',
						'parent_memo' => 'Great day',
				]);

				// Assert that the response redirects with a success message
				$response->assertRedirect();
				$response->assertSessionHas('message', '出欠確認の処理が完了しました。');
				$response->assertSessionHas('status', 'success');
		}
}
