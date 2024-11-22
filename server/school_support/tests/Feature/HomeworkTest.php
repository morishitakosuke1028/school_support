<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\GradeClass;
use App\Models\Homework;

class HomeworkTest extends TestCase
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

        GradeClass::factory()->count(3)->create();

        $response = $this->actingAs($user)->get(route('homeworks.index'));

        $response->assertStatus(200);
        $response->assertInertia(function ($page) {
            $page->component('Homework/Index')
                ->has('gradeClasses.data', 3)
                ->where('currentUserRole', true);
        });
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

        $gradeClass = GradeClass::factory()->create();
        Homework::factory()->count(5)->create(['grade_class_id' => $gradeClass->id]);

        $response = $this->get(route('homeworks.edit', $gradeClass->id));

        $response->assertStatus(200);
        $response->assertInertia(function ($page) use ($gradeClass) {
            $page->component('Homework/Edit')
                ->where('gradeClass.id', $gradeClass->id)
                ->has('homeworks', 5);
        });
    }

    /**
     * BulkStore メソッドのテスト
     *
     * @return void
     */
    public function test_bulk_store()
    {
        $user = $this->createUser();
        $this->actingAs($user);

        $gradeClass = GradeClass::factory()->create();

        $homeworkData = [
            '2024-08-12' => [
                'grade_class_id' => $gradeClass->id,
                'homework_day' => '2024-08-12',
                'reading' => 'Read chapter 1',
                'language_drill' => 'Complete exercise 1',
                'arithmetic' => 'Solve problems 1-10',
                'diary' => 'Write about your day',
                'ipad' => 'true',
                'other' => 'Practice piano',
            ],
            '2024-08-13' => [
                'grade_class_id' => $gradeClass->id,
                'homework_day' => '2024-08-13',
                'reading' => 'Read chapter 2',
                'language_drill' => 'Complete exercise 2',
                'arithmetic' => 'Solve problems 11-20',
                'diary' => 'Write about your dreams',
                'ipad' => 'false',
                'other' => 'Draw a picture',
            ],
        ];

        $existingHomework = Homework::factory()->create(['grade_class_id' => $gradeClass->id]);

        $response = $this->post(route('homeworks.bulkStore', ['homework' => $existingHomework->id]), ['homeworkData' => $homeworkData]);

        $response->assertRedirect(route('homeworks.index'));
        $response->assertSessionHas('message', '一括登録が完了しました。');
        $response->assertSessionHas('status', 'success');

        foreach ($homeworkData as $date => $data) {
            $this->assertDatabaseHas('homework', [
                'grade_class_id' => $data['grade_class_id'],
                'homework_day' => $data['homework_day'],
                'reading' => $data['reading'],
                'language_drill' => $data['language_drill'],
                'arithmetic' => $data['arithmetic'],
                'diary' => $data['diary'],
                'ipad' => $data['ipad'],
                'other' => $data['other'],
            ]);
        }
    }
}
