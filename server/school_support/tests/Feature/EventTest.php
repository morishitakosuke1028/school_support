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

        // 必要なテストデータを作成
        $gradeClasses = GradeClass::factory()->count(2)->create();

        // 同じgrade_class_idを持つイベントを3つ作成
        $eventGradeClass = $gradeClasses->first();
        Event::factory()->count(3)->create([
            'grade_class_id' => $eventGradeClass->id,
        ]);

        $response = $this->get(route('events.index'));

        $response->assertStatus(200);
        $response->assertInertia(function ($page) use ($gradeClasses) {
            $page->component('Event/Index')
                ->has('events', 3)
                ->where('gradeClasses', function ($gradeClassesCollection) use ($gradeClasses) {
                    return $gradeClassesCollection->count() === $gradeClasses->count();
                })
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
        $this->actingAs($user);

        $response = $this->get(route('events.create', ['date' => '2024-08-12', 'gradeClassId' => 1]));

        $response->assertStatus(200);
        $response->assertInertia(function ($page) {
            $page->component('Event/Create');
        });
    }

    /**
     * Store メソッドのテスト
     *
     * @return void
     */
    public function test_store()
    {
        $user = $this->createUser();
        $this->actingAs($user);

        $gradeClass = GradeClass::factory()->create();

        $data = [
            'grade_class_id' => $gradeClass->id,
            'start_datetime' => '2024-08-12 09:00:00',
            'end_datetime' => '2024-08-12 11:00:00',
            'title' => 'Event Title',
            'place' => 'Event Place',
            'personal_effect' => 'Event Personal Effect',
            'content' => 'Event Content',
        ];

        $response = $this->post(route('events.store'), $data);

        $response->assertRedirect(route('events.index'));
        $response->assertSessionHas('message', '登録しました。');
        $response->assertSessionHas('status', 'success');

        $this->assertDatabaseHas('events', $data);
    }

		/**
     * Edit メソッドのテスト
     *
     * @return void
     */
    public function test_edit()
    {
        $user = $this->createUser();
        $this->actingAs($user);

        $event = Event::factory()->create();

        $response = $this->get(route('events.edit', $event));

        $response->assertStatus(200);
        $response->assertInertia(function ($page) use ($event) {
            $page->component('Event/Edit')
                ->where('event.id', $event->id);
        });
    }

		/**
     * Update メソッドのテスト
     *
     * @return void
     */
    public function test_update()
    {
        $user = $this->createUser();
        $this->actingAs($user);

        $event = Event::factory()->create();

        $data = [
            'grade_class_id' => $event->grade_class_id,
            'start_datetime' => '2024-08-12 10:00:00',
            'end_datetime' => '2024-08-12 12:00:00',
            'title' => 'Updated Event Title',
            'place' => 'Updated Event Place',
            'personal_effect' => 'Updated Personal Effect',
            'content' => 'Updated Event Content',
        ];

        $response = $this->put(route('events.update', $event), $data);

        $response->assertRedirect(route('events.index'));
        $response->assertSessionHas('message', '更新しました。');
        $response->assertSessionHas('status', 'success');

        $this->assertDatabaseHas('events', $data);
    }

		/**
     * Check メソッドのテスト
     *
     * @return void
     */
    public function test_check_with_existing_event()
    {
        $user = $this->createUser();
        $this->actingAs($user);

        $gradeClass = GradeClass::factory()->create();
        $event = Event::factory()->create([
            'grade_class_id' => $gradeClass->id,
            'start_datetime' => '2024-08-12 09:00:00',
        ]);

        $response = $this->get(route('events.check', ['date' => '2024-08-12', 'gradeClassId' => $gradeClass->id]));

        $response->assertRedirect(route('events.edit', $event));
    }

    public function test_check_with_no_existing_event()
    {
        $user = $this->createUser();
        $this->actingAs($user);

        $gradeClass = GradeClass::factory()->create();

        $response = $this->get(route('events.check', ['date' => '2024-08-12', 'gradeClassId' => $gradeClass->id]));

        $response->assertRedirect(route('events.create', ['date' => '2024-08-12', 'gradeClassId' => $gradeClass->id]));
    }

		/**
     * Destroy メソッドのテスト
     *
     * @return void
     */
    public function test_destroy()
    {
        $user = $this->createUser();
        $this->actingAs($user);

        $event = Event::factory()->create();

        $response = $this->delete(route('events.destroy', $event));

        $response->assertRedirect(route('events.index'));
        $response->assertSessionHas('message', '削除しました。');
        $response->assertSessionHas('status', 'danger');

        $this->assertDatabaseMissing('events', [
            'id' => $event->id,
        ]);
    }
}
