<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCsvImportRequest;
use Illuminate\Http\Request;
use App\Models\Child;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Carbon\Carbon;

class csvImportController extends Controller
{
    public function create()
    {
        return Inertia::render('CsvImport/Create');
    }

    public function store(StoreCsvImportRequest $request)
    {
        $file = $request->file('csv_file');

        if (($handle = fopen($file->getRealPath(), 'r')) !== false) {
            fgetcsv($handle);

            while (($row = fgetcsv($handle)) !== false) {
                if (array(null) !== $row) {
                    $birthday = \DateTime::createFromFormat('Y/m/d', $row[5]);
                    $admission_date = \DateTime::createFromFormat('Y/m/d', $row[6]);

                    $birthday = $birthday ? $birthday->format('Y-m-d') : null;
                    $admission_date = $admission_date ? $admission_date->format('Y-m-d') : null;
                    $data = [
                        'name' => $row[0],
                        'kana' => $row[1],
                        'gender' => $row[2],
                        'zip' => $row[3],
                        'address' => $row[4],
                        'birthday' => $birthday,
                        'admission_date' => $admission_date,
                        'email' => $row[7],
                        'tel' => $row[8],
                        'pin_code' => $row[9],
                        'session_id' => $row[10],
                        'password' => Hash::make($row[11]),
                        'school_id' => 1,
                    ];

                    $validator = Validator::make($data, [
                        'name' => 'required|string|max:255',
                        'kana' => 'nullable|string|max:255',
                        'email' => 'required|string|email|max:255|unique:children,email',
                        'zip' => 'nullable|digits:7',
                        'address' => 'nullable|string|max:255',
                        'tel' => 'required|string|max:13',
                        'gender' => 'required|in:1,2',
                        'admission_date' => 'required|date',
                        'birthday' => 'nullable|date',
                        'pin_code' => 'required|string|max:255',
                        'session_id' => 'required|string|max:255',
                        'password' => 'required|string|min:8',
                    ]);

                    if ($validator->fails()) {
                        fclose($handle);
                        return response()->json($validator->errors(), 422);
                    }

                    Child::create($data);
                }
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
