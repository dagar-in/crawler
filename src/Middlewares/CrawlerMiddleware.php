<?php

namespace Dagar\Crawler\Middlewares;

use Closure;
use Dagar\Crawler\Crawler;
use Dagar\Crawler\Models\EntryModel;

class CrawlerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        
        if (strpos($request->url(), config('crawler.uri')) == false) {

            $requestLog = Crawler::extractRequest($request);

            if(EntryModel::where('request_id', ($requestLog['requestId'] ?? uniqid()))->count() == 0) {
            
                EntryModel::create([
                    'type' => 'request',
                    'request_id' => $requestLog['requestId'] ?? uniqid(),
                    'content' => ($requestLog),
                ]);

            }
        }
        return $next($request);
    }

    /**
     * Handle tasks after the response has been sent to the browser.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Http\Response  $response
     * @return void
     */
    public function terminate($request, $response)
    {
        if (strpos($request->requestUri, config('crawler.uri'))) {
            
            $responseLog = Crawler::extractResponse($response);

            $uniqId = 'R.'.($responseLog['requestId'] ?? uniqid());
            
            if(EntryModel::where('request_id', $uniqId)->count() == 0) {
                EntryModel::create([
                    'type' => 'response',
                    'request_id' =>  $uniqId,
                    'content' => ($responseLog),
                ]);
            }
        }
    }
}
