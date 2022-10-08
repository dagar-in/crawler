<?php

namespace Dagar\Crawler\Controllers;

use Illuminate\Http\Request;
use Dagar\Crawler\Crawler;
use Dagar\Crawler\Models\EntryModel;

class CrawlerController {

    public function __invoke() {

    }

    public function index() {

        $paginator = EntryModel::orderBy('id', 'desc')->paginate(10);

        return view('crawler::index', compact('paginator'));
    }

    public function view(Request $request,$id) {
        $id = (int)$id;
        $log = EntryModel::where('id', $id)->first();
        return view('crawler::view', compact('log'));
    }

}
