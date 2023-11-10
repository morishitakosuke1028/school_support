<?php

namespace App\Http\Controllers;

use App\Models\Child;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ChildController extends Controller
{
    public function index(Request $request)
	{
            $pageNumber = $request->input('page', 1); // デフォルトのページ番号を1に設定
            \Log::info('Requested page number: ' . $pageNumber);

            $authUserId = Auth::id();
            $children = Child::select('id', 'name', 'tel', 'email', 'admission_date')->paginate(50);

			return Inertia::render('Child/Index', [
                'children' => $children,
                'authUserId' => $authUserId
			]);
	}

    public function edit(Child $child)
    {
        return Inertia::render('Child/Edit', [
            'child' => $child
        ]);
    }

    public function update(Request $request, $id)
    {
        $child = Child::findOrFail($id);
        $child->name = $request->name;
        $child->kana = $request->kana;
        $child->gender = $request->gender;
        $child->zip = $request->zip;
        $child->address = $request->address;
        $child->birthday = $request->birthday;
        $child->admission_date = $request->admission_date;
        $child->email = $request->email;
        $child->tel = $request->tel;
        $child->pin_code = $request->pin_code;
        $child->session_id = $request->session_id;
        $child->movein_date = $request->movein_date;
        $child->graduation_date = $request->graduation_date;
        $child->save();
        return to_route('child.index')
        ->with([
            'message' => '更新しました。',
            'status' => 'success',
        ]);
    }
}
