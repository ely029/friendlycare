<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

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
}
