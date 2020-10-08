<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\BasicPages;
use App\Http\Controllers\Controller;

class BasicPagesController extends Controller
{
    public function index()
    {
        $content = BasicPages::all();
        return view('admin.basicPages.index', ['content' => $content]);
    }

    public function editPage($id)
    {
        $content = BasicPages::where('id', $id)->get();
        return view('admin.basicPages.editPage', ['content' => $content]);
    }

    public function storeEdit()
    {
        $request = request()->all();
        BasicPages::find($request['id'])->update([
            'content_name' => $request['content_name'],
            'content' => $request['contents'],
        ]);

        return redirect('basicpages/list');
    }
}
