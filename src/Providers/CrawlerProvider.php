<?php

namespace Dagar\Crawler\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\Facades\DB;

use Dagar\Crawler\Middlewares\CrawlerMiddleware;
use Dagar\Crawler\Models\EntryModel;

class CrawlerProvider extends ServiceProvider
{

    public function boot(Kernel $kernel)
    {

        $this->app->q = 0;

        /*
         * Register the middleware
         */
        $kernel->prependMiddleware(CrawlerMiddleware::class);

        /*
         * Register the routes
         */
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        /*
         * Register the views
         */
        $this->loadViewsFrom(__DIR__ . '/../views', 'crawler');

        /*
         * Register the migrations
         */
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    public function register()
    {
        // $this->app->singleton(CrawlerMiddleware::class, function ($app) {
        //     return new CrawlerMiddleware();
        // });

        $save_query = env('SAVE_QUERY', true);

        if ($save_query) {

            DB::listen(function ($query) {

                if(strpos($query->sql, 'crawler_entries') == false){

                    EntryModel::create([
                        'type' => 'query',
                        'request_id' => substr(time(),0,-8).'-'. request()->requestId,
                        'content' => array_merge([
                            [$query->sql], $query->bindings
                        ]),
                    ]);

                }

            });
        }
    }
}
