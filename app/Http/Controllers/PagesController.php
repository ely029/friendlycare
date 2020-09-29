<?php

declare(strict_types=1);

namespace App\Http\Controllers;

class PagesController extends Controller
{
    public function newFeatures()
    {
        return view('pages.new_features');
    }

    public function press()
    {
        return view('pages.press');
    }

    public function newHires()
    {
        return view('pages.new_hires');
    }

    public function about()
    {
        return view('pages.about');
    }
}
