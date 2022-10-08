<?php

use Dagar\Crawler\Controllers\CrawlerController;
use Illuminate\Support\Facades\Route;

$root = env('CRAWL_UI_ENDPOINT', 'crawl');

Route::get($root, [CrawlerController::class, 'index'])->name('crawler.dashboard');

Route::get("$root/{id}", [CrawlerController::class, 'view'])->name('crawler.view');
