<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'ExampleController@index');

Route::middleware(['auth:api'])->group(function () {

});
