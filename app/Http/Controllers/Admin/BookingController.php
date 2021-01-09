<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Clinics;
use App\FamilyPlanTypeSubcategories;
use App\Http\Controllers\Controller;

class BookingController extends Controller
{
    public function index()
    {
        $services = FamilyPlanTypeSubcategories::get();
        $clinics = Clinics::get();
        return view('admin.bookings.index', ['services' => $services, 'clinics' => $clinics]);
    }
}
