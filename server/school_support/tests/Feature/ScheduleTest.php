<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Schedule;
use App\Models\Subject;
use App\Models\GradeClass;
use App\Models\User;

class ScheduleTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_displays_schedule_list()
    {
        $user = User::factory()->create(['role' => 1]);
        $this->actingAs($user);

        GradeClass::factory()->count(3)->create();

        $response = $this->actingAs($user)->get(route('schedules.index'));
        $response->assertStatus(200);
        $response->assertInertia(function ($page) {
            $page->component('Schedule/Index')
                ->has('gradeClasses.data', 3)
                ->where('currentUserRole', true);
        });
    }

		/**
     * Test the edit method of the ScheduleController.
     *
     * @return void
     */
    public function test_edit_displays_edit_page_with_correct_data()
    {
        // Create a user and grade class
        $user = User::factory()->create();
        $this->actingAs($user);

        $gradeClass = GradeClass::factory()->create();
        $subjects = Subject::factory()->count(3)->create();

        // Specify the schedule_date to avoid the error
        $schedules = Schedule::factory()->count(2)->create([
            'grade_class_id' => $gradeClass->id,
            'schedule_date' => now(),  // Providing a valid date for schedule_date
            'subject_id_first' => 1,   // Ensure other fields are populated as needed
        ]);

        // Test the request to the edit page
        $response = $this->get(route('schedules.edit', $gradeClass->id));

        // Assert the status is 200
        $response->assertStatus(200);

        // Assert the correct data is passed to the view
        $response->assertInertia(fn ($page) =>
            $page->component('Schedule/Edit')
                ->where('gradeClassId', $gradeClass->id)
                ->has('gradeClass')
                ->has('subjects', 3)
                ->has('schedules', 2)
        );
    }
}
