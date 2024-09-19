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
}
