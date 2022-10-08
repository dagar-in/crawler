<?php

use Dagar\Crawler\Controllers\CrawlerController;
use Illuminate\Support\Facades\Route;

$root = config('crawler.uri', 'crawler');

Route::get($root, [CrawlerController::class, 'index'])->name('crawler.dashboard');

Route::get("$root/{id}", [CrawlerController::class, 'view'])->name('crawler.view');
