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

		/**
     * Create メソッドのテスト
     *
     * @return void
     */
    public function test_create()
    {
        $user = $this->createUser();
        $this->actingAs($user);

        $response = $this->get(route('subjects.create'));

        $response->assertStatus(200);
        $response->assertInertia(function ($page) {
            $page->component('Subject/Create');
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

        $data = [
            'name' => 'Mathematics',
        ];

        $response = $this->post(route('subjects.store'), $data);

        $response->assertRedirect(route('subjects.index'));
        $response->assertSessionHas('message', '登録しました。');
        $response->assertSessionHas('status', 'success');

        $this->assertDatabaseHas('subjects', $data);
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

        $subject = Subject::factory()->create();

        $response = $this->get(route('subjects.edit', $subject));

        $response->assertStatus(200);
        $response->assertInertia(function ($page) use ($subject) {
            $page->component('Subject/Edit')
                ->where('subject.id', $subject->id);
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

        $subject = Subject::factory()->create();

        $data = [
            'name' => 'Updated Subject Name',
        ];

        $response = $this->put(route('subjects.update', $subject), $data);

        $response->assertRedirect(route('subjects.index'));
        $response->assertSessionHas('message', '更新しました。');
        $response->assertSessionHas('status', 'success');

        $this->assertDatabaseHas('subjects', $data);
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

        $subject = Subject::factory()->create();

        $response = $this->delete(route('subjects.destroy', $subject));

        $response->assertRedirect(route('subjects.index'));
        $response->assertSessionHas('message', '削除しました。');
        $response->assertSessionHas('status', 'danger');

        $this->assertDatabaseMissing('subjects', [
            'id' => $subject->id,
        ]);
    }
}
