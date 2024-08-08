<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Contact;
use App\Models\User;
use App\Models\Child;
use App\Models\GradeClass;
use App\Models\GradeClassHistory;
use Illuminate\Support\Facades\Auth;

class ContactTest extends TestCase
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

        $response = $this->actingAs($user)->get(route('contacts.index'));

        $response->assertStatus(200);
        $response->assertInertia(function ($page) {
            $page->component('Contact/Index')
                ->has('children', 1);
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
        Contact::factory()->create([
            'child_id' => $child->id,
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->get(route('contacts.create', ['contact' => $child->id]));

        $response->assertStatus(200);
        $response->assertInertia(function ($page) use ($child, $user) {
            $page->component('Contact/Create')
                ->has('contacts', 1)
                ->where('child.id', $child->id)
                ->where('currentUserRole', true)
                ->where('currentUser', $user->id)
                ->where('currentUserName', $user->name);
        });
    }
}
