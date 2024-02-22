<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCsvImportRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class csvImportController extends Controller
{
    public function create()
    {
        return Inertia::render('CsvImport/Create');
    }
}
