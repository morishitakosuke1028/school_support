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
        $user = User::factory()->create();
        $this->actingAs($user);

        $gradeClass = GradeClass::factory()->create();
        $subjects = Subject::factory()->count(3)->create();

        $schedules = Schedule::factory()->count(2)->create([
            'grade_class_id' => $gradeClass->id,
            'schedule_date' => now(),
            'subject_id_first' => 1,
        ]);

        $response = $this->get(route('schedules.edit', $gradeClass->id));

        $response->assertStatus(200);

        $response->assertInertia(fn ($page) =>
            $page->component('Schedule/Edit')
                ->where('gradeClassId', $gradeClass->id)
                ->has('gradeClass')
                ->has('subjects', 3)
                ->has('schedules', 2)
        );
    }

    public function test_bulk_store_saves_schedules_and_redirects()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $gradeClass = GradeClass::factory()->create();

        $scheduleData = [
            '2024-09-20' => [
                'grade_class_id' => $gradeClass->id,
                'subject_id_first' => 1,
            ],
            '2024-09-21' => [
                'grade_class_id' => $gradeClass->id,
                'subject_id_first' => 2,
            ],
        ];

        $response = $this->post(route('schedules.bulkStore', ['schedule' => 1]), [
            'scheduleData' => $scheduleData
        ]);

        $this->assertDatabaseHas('schedules', [
            'grade_class_id' => $gradeClass->id,
            'subject_id_first' => 1,
            'schedule_date' => '2024-09-20',
        ]);
        $this->assertDatabaseHas('schedules', [
            'grade_class_id' => $gradeClass->id,
            'subject_id_first' => 2,
            'schedule_date' => '2024-09-21',
        ]);

        $response->assertRedirect(route('schedules.index'));
        $response->assertSessionHas('message', '一括登録が完了しました。');
        $response->assertSessionHas('status', 'success');
    }

    public function test_bulk_store_handles_error_gracefully()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $schedule = Schedule::factory()->create();

        $scheduleData = [
            '2024-09-20' => [
                'grade_class_id' => 1,
                'subject_id_first' => 1,
                'schedule_date' => now(),
            ],
            '2024-09-21' => [
                'grade_class_id' => 1,
                'subject_id_first' => 2,
                'schedule_date' => now(),
            ],
        ];

        $this->mock(Schedule::class, function ($mock) {
            $mock->shouldReceive('bulkStore')->andThrow(new \Exception('Mocked exception'));
        });

        $response = $this->post(route('schedules.bulkStore', ['schedule' => $schedule->id]), [
            'scheduleData' => $scheduleData,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('message', '登録に失敗しました。');
        $response->assertSessionHas('status', 'error');

        $this->assertDatabaseMissing('schedules', [
            'subject_id_first' => 1,
            'schedule_date' => '2024-09-20',
        ]);
        $this->assertDatabaseMissing('schedules', [
            'subject_id_first' => 2,
            'schedule_date' => '2024-09-21',
        ]);
    }
}
