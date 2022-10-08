<?php

namespace Dagar\Crawler\Controllers;

use Illuminate\Http\Request;
use Dagar\Crawler\Crawler;
use Dagar\Crawler\Models\EntryModel;
use Illuminate\Support\Facades\Log;

class CrawlerController
{

    public function __invoke()
    {
        if(config('crawler.security.ip')) {
            If(Crawler::CheckIpWhitelist() == false) {
                Log::Info('Unauthorized IP Detected, Request Blocked  - ' . request()->ip());
                return response('Unauthorized.', 401);
            }
        }

        if(config('crawler.security.user_agent')) {
            if(Crawler::CheckUserAgentWhitelist()){
                Log::Info('Unauthorized User Agent Detected, Request Blocked  - ' . request()->userAgent());
                return response('Unauthorized.', 401);
            }
        }

        if(config('crawler.security.referer')) {
            if(Crawler::CheckRefererWhitelist()){
                Log::Info('Unauthorized Referer Detected, Request Blocked  - ' . request()->headers->get('referer'));
                return response('Unauthorized.', 401);
            }
        }

    }

    public function index()
    {

        try {

            $paginator = EntryModel::orderBy('id', 'desc')->paginate(10);

            return view('crawler::index', compact('paginator'));

        } catch (\Throwable $th) {
            Log::Debug($th);
        }
    }

    public function view(Request $request, $id)
    {

        try {

            $id = (int)$id;
            $log = EntryModel::where('id', $id)->first();
            return view('crawler::view', compact('log'));

        } catch (\Throwable $th) {
            Log::Debug($th);
        }
    }
}
