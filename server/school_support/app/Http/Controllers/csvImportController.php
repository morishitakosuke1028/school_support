<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCsvImportRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class csvImportController extends Controller
{
    public function create()
    {
        return Inertia::render('CsvImport/Create');
    }

    public function store(StoreCsvImportRequest $request)
    {
        $file = $request->file('csv_file');
        if (($handle = fopen($file->getRealPath(), 'r')) !== FALSE) {
            $header = fgetcsv($handle);

            while (($row = fgetcsv($handle)) !== FALSE) {
                $rowData = array_combine($header, $row);

                $validator = Validator::make($rowData, [
                    'name' => 'required|string|max:255',
                    'kana' => 'nullable|string|max:255|regex:/^[\p{Hiragana}\s]+$/u',
                    'email' => 'required|string|email|max:255|unique:'.child::class,
                    'zip' => 'nullable|digits:7',
                    'address' => 'nullable|string|max:255',
                    'tel' => 'required|string|max:13',
                    'gender' => 'required|in:1,2',
                    'admission_date' => 'required|date_format:Y-m-d',
                    'birthday' => 'nullable|date_format:Y-m-d',
                    'pin_code' => 'required|string|max:255',
                    'session_id' => 'required|string|max:255',
                    'school_id' => 'required|string',
                    'password' => ['required', 'confirmed', Rules\Password::defaults()],
                ]);

                if ($validator->fails()) {
                    fclose($handle);
                    return back()->withErrors($validator)->withInput();
                }

                Child::create($rowData);
            }

            fclose($handle);
        }
        return to_route('admin.child.index')
        ->with([
            'message' => '送信しました。',
            'status' => 'success',
        ]);
    }
}
