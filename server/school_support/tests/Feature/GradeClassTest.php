<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\GradeClass;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GradeClassTest extends TestCase
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
        Auth::login($user);

        GradeClass::factory()->count(3)->create();

        $response = $this->actingAs($user)->get(route('gradeClasses.index'));

        $response->assertStatus(200);
        $response->assertInertia(function ($page) {
            $page->component('GradeClass/Index')
                ->has('gradeClasses.data', 3)
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
        Auth::login($user);

        $response = $this->actingAs($user)->get(route('gradeClasses.create'));

        $response->assertStatus(200);
        $response->assertInertia(function ($page) {
            $page->component('GradeClass/Create');
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
            'grade_name' => '一年',
            'class_name' => 'A',
            'school_id' => 1,
        ];

        $response = $this->post(route('gradeClasses.store'), $data);

        $response->assertRedirect(route('gradeClasses.index'));
        $response->assertSessionHas('message', '登録しました。');
        $response->assertSessionHas('status', 'success');

        $this->assertDatabaseHas('grade_classes', $data);
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

        $gradeClass = GradeClass::factory()->create([
            'grade_name' => '一年',
            'class_name' => 'A',
            'school_id' => 1,
        ]);

        $response = $this->get(route('gradeClasses.edit', $gradeClass));

        $response->assertStatus(200);
        $response->assertInertia(function ($page) use ($gradeClass) {
            $page->component('GradeClass/Edit')
                ->where('gradeClass.id', $gradeClass->id)
                ->where('gradeClass.grade_name', $gradeClass->grade_name)
                ->where('gradeClass.class_name', $gradeClass->class_name)
                ->where('gradeClass.school_id', $gradeClass->school_id);
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

        $gradeClass = GradeClass::factory()->create([
            'grade_name' => '一年',
            'class_name' => 'A',
            'school_id' => 1,
        ]);

        $data = [
            'grade_name' => '二年',
            'class_name' => 'B',
        ];

        $response = $this->put(route('gradeClasses.update', $gradeClass), $data);

        $response->assertRedirect(route('gradeClasses.index'));
        $response->assertSessionHas('message', '更新しました。');
        $response->assertSessionHas('status', 'success');

        $this->assertDatabaseHas('grade_classes', [
            'id' => $gradeClass->id,
            'grade_name' => '二年',
            'class_name' => 'B',
        ]);
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

        $gradeClass = GradeClass::factory()->create([
            'grade_name' => '一年',
            'class_name' => 'A',
            'school_id' => 1,
        ]);

        $response = $this->delete(route('gradeClasses.destroy', $gradeClass));

        $response->assertRedirect(route('gradeClasses.index'));
        $response->assertSessionHas('message', '削除しました。');
        $response->assertSessionHas('status', 'danger');

        $this->assertDatabaseMissing('grade_classes', [
            'id' => $gradeClass->id,
        ]);
    }
}
