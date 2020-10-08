<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\BasicPages;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BasicPagesController extends Controller
{
    public function consentForm()
    {
        $content = BasicPages::where('id', 3)->first();

        return response()->json($content, 200);
    }
}
