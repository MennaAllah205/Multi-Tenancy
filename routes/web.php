<?php

use App\Jobs\FirstTaskJob;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Bus;

Route::get('/', function () {

// Bus::chain([
//     new \App\Jobs\FirstTaskJob(),
//     new \App\Jobs\SecondTaskJob(),
// ])->dispatch();

// Bus::batch([
//     new \App\Jobs\FirstTaskJob(),
//     new \App\Jobs\SecondTaskJob(),
// ])->dispatch();

dispatch(new FirstTaskJob ())->onQueue('menna');

    return view('welcome');
});

Route::get('/test', function () {
    dd(config('firebase.credentials'));
});
