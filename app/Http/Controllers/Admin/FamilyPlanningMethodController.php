<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FamilyPlanningMethodController extends Controller
{
    public function index()
    {
        return view('admin.familyPlanningMethod.index');
    }

    public function firstPage()
    {
        return view('admin.familyPlanningMethod.create.firstPage');
    }

    public function secondPage()
    {
        return view('admin.familyPlanningMethod.create.secondPage');
    }

    public function createOne(Request $request)
    {
        $request->file('icon');
        return response('testing');
    }
}
