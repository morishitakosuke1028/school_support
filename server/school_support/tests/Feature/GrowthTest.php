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

    /**
     * Create メソッドのテスト
     *
     * @return void
     */
    public function test_create()
    {
        $user = $this->createUser();
        $this->actingAs($user);

        $child = Child::factory()->create();

        $response = $this->get(route('growths.create', ['growth' => $child->id]));

        $response->assertStatus(200);
        $response->assertInertia(function ($page) use ($child) {
            $page->component('Growth/Create')
                ->where('child.id', $child->id)
                ->has('growths');
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

        $child = Child::factory()->create();

        $data = [
            'child_id' => $child->id,
            'height' => 120.5,
            'weight' => 35.2,
            'chest' => 60.0,
            'abdomen' => 55.0,
            'head' => 50.0,
            'measurement_month' => '2024-08-01',
        ];

        $response = $this->post(route('growths.store'), $data);

        $response->assertRedirect(route('growths.index'));
        $response->assertSessionHas('message', '登録しました。');
        $response->assertSessionHas('status', 'success');

        $this->assertDatabaseHas('growths', $data);
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

        $child = Child::factory()->create();
        $growth = Growth::factory()->create(['child_id' => $child->id]);

        $response = $this->get(route('growths.edit', $growth));

        $response->assertStatus(200);
        $response->assertInertia(function ($page) use ($growth, $child) {
            $page->component('Growth/Edit')
                ->where('growth.id', $growth->id)
                ->where('child.id', $child->id);
        });
    }
}
