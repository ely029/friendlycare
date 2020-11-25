<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\BasicPages;
use App\BasicPageSection;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class BasicPagesController extends Controller
{
    public function index()
    {
        $content = BasicPages::all();
        return view('admin.basicPages.index', ['content' => $content]);
    }

    public function informationPage($id)
    {
        $contents = DB::table('basic_page_section')
            ->select('basic_page_section.title as section_title', 'basic_page_section.content')
            ->where('basic_page_id', $id)
            ->get();

        $content = BasicPages::where('id', $id)->get();

        return view('admin.basicPages.informationPage', ['content' => $content, 'contents' => $contents]);
    }
    public function editPage($id)
    {
        $contents = DB::table('basic_page_section')->select('title', 'content')->where('basic_page_id', $id)->get();
        $content = BasicPages::where('id', $id)->get();
        return view('admin.basicPages.editPage', ['content' => $content, 'contentss' => $contents]);
    }
    public function storeEdit()
    {
        $request = request()->all();
        if ($request['id'] === '3') {
            $this->checkAndInsertofData($request);
        }
        BasicPages::find($request['id'])->update([
            'content_name' => $request['content_name'],
            'content' => $request['content'],
        ]);

        return redirect('basicpages/list');
    }

    public function updateBasicPageSection($checkCount, $request, $eee)
    {
        if ($checkCount >= 1) {
            BasicPageSection::where('title', $request['title'][$eee])->update([
                'title' => $request['title'][$eee],
                'content' => $request['content'][$eee],
            ]);
        }

        BasicPageSection::create([
            'basic_page_id' => $request['id'],
            'title' => $request['title'][$eee],
            'content' => $request['content'][$eee],
        ]);
    }
    private function checkAndInsertofData($request)
    {
        for ($eee = 0;$eee <= 1000;$eee++) {
            if (isset($request['title'][$eee])) {
                $checkCount = DB::table('basic_page_section')
                    ->select('id')
                    ->where('title', $request['title'][$eee])->count();
                $this->updateBasicPageSection($checkCount, $request, $eee);
            }
        }
    }
}
