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
            ->select('basic_page_section.section_title_1 as section_title', 'basic_page_section.content', 'basic_page_section.id')
            ->where('basic_page_id', $id)
            ->get();

        $content = BasicPages::where('id', $id)->get();

        return view('admin.basicPages.informationPage', ['content' => $content, 'contents' => $contents]);
    }
    public function editPage($id)
    {
        $contents = DB::table('basic_page_section')->select('section_title_1 as title', 'content', 'id')->where('basic_page_id', $id)->get();
        $content = BasicPages::where('id', $id)->get();
        return view('admin.basicPages.editPage', ['content' => $content, 'contentss' => $contents]);
    }
    public function storeEdit()
    {
        $request = request()->all();
        if ($request['id'] === '3') {
            $this->checkAndInsertofData($request);
        } else {
            BasicPages::find($request['id'])->update([
                'content_name' => $request['content_name'],
                'content' => $request['content'],
            ]);
        }

        return redirect('basicpages/list');
    }

    public function updateBasicPageSection($checkCount, $request, $eee)
    {
        if ($checkCount >= 1) {
            BasicPageSection::where('id', $request['content_id'][$eee])->update([
                'section_title_1' => $request['content_name'][$eee],
                'content' => $request['content'][$eee],
            ]);
        } else {
            BasicPageSection::create([
                'basic_page_id' => $request['id'],
                'section_title_1' => $request['content_name'][$eee],
                'content' => $request['content'][$eee],
            ]);
        }
    }
    public function deleteBasicSection($id)
    {
        BasicPageSection::where('id', $id)->delete();

        return redirect('basicpages/edit/3');
    }
    private function checkAndInsertofData($request)
    {
        for ($eee = 0;$eee <= 1000;$eee++) {
            if (isset($request['content_id'][$eee])) {
                $checkCount = DB::table('basic_page_section')
                    ->select('id')
                    ->where('id', $request['content_id'][$eee])->count();
                $this->updateBasicPageSection($checkCount, $request, $eee);
            }
        }
    }
}
