<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\BasicPages;
use App\BasicPageSection;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BasicPagesController extends Controller
{
    public function consentForm()
    {
        $content = BasicPages::where('id', 3)->first();

        return response()->json($content, 200);
    }

    public function consentFormSection()
    {
        $content = BasicPageSection::where('basic_page_id', 3)->get();

        return response([
            'name' => 'consentFormSection',
            'detail' => $content,
        ]);
    }

    public function aboutUs()
    {
        $content = BasicPages::where('id', 1)->first();

        return response()->json($content, 200);
    }

    public function termsOfService()
    {
        $content = BasicPages::where('id', 2)->first();

        return response()->json($content, 200);
    }
}
