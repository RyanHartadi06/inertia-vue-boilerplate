<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'Auth\LoginController@showLoginForm')->middleware('guest')->name('login');
Route::post('/login', 'Auth\LoginController@login')->middleware('guest')->name('login.attempt');

Route::middleware('auth')->group(function () {
    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
    Route::get('/dashboard', 'Dashboard\DashboardController@index')->name('dashboard')->middleware('permission:view dashboard');

    Route::prefix('/account')->group(function () {
        Route::get('/', 'User\ProfileController@index')->name('profile.index');
        Route::get('/edit', 'User\ProfileController@edit')->name('profile.edit');
        Route::put('/edit', 'User\ProfileController@update')->name('profile.update');
    });

    Route::prefix('/users')->middleware('permission:view users')->group(function () {
        Route::get('/', 'User\UserController@index')->name('users.index')->middleware('permission:view users');;
        Route::get('/{user}', 'User\UserController@show')->name('users.show')->middleware('permission:view users');;
        Route::get('/{user}/edit', 'User\UserController@edit')->name('users.edit')->middleware('permission:edit users');;
        Route::put('/{user}/update', 'User\UserController@update')->name('users.update')->middleware('permission:edit users');;
    });

    Route::prefix('/roles')->middleware('permission:view roles')->group(function () {
        Route::get('/', 'Role\RoleController@index')->name('roles.index');
        Route::get('/{role}', 'Role\RoleController@show')->name('roles.show');
        Route::get('/{role}/edit', 'Role\RoleController@edit')->name('roles.edit')->middleware('permission:edit roles');
        Route::put('/{role}/update', 'Role\RoleController@update')->name('roles.update')->middleware('permission:edit roles');
    });

    Route::prefix('/periods')->middleware('permission:view periods')->group(function () {
        Route::get('/', 'PerformanceIndicator\PeriodController@index')->name('periods.index')->middleware('permission:view periods');
        Route::get('/create', 'PerformanceIndicator\PeriodController@create')->name('periods.create')->middleware('permission:create periods');
        Route::post('/store', 'PerformanceIndicator\PeriodController@store')->name('periods.store')->middleware('permission:create periods');
        Route::get('/{period}/edit', 'PerformanceIndicator\PeriodController@edit')->name('periods.edit')->middleware('permission:edit periods');
        Route::put('/{period}/update', 'PerformanceIndicator\PeriodController@update')->name('periods.update')->middleware('permission:edit periods');
        Route::put('/{period}/update-status', 'PerformanceIndicator\PeriodController@updateStatus')->name('periods.update-status')->middleware('permission:edit periods');
        Route::delete('/{period}', 'PerformanceIndicator\PeriodController@destroy')->name('periods.destroy')->middleware('permission:delete periods');
    });

    Route::prefix('/indicator-units')->middleware('permission:view indicator-units')->group(function () {
        Route::get('/', 'PerformanceIndicator\IndicatorUnitController@index')->name('indicator-units.index')->middleware('permission:view indicator units');
        Route::get('/create', 'PerformanceIndicator\IndicatorUnitController@create')->name('indicator-units.create')->middleware('permission:create indicator units');
        Route::post('/store', 'PerformanceIndicator\IndicatorUnitController@store')->name('indicator-units.store')->middleware('permission:create indicator units');
        Route::get('/{unit}/edit', 'PerformanceIndicator\IndicatorUnitController@edit')->name('indicator-units.edit')->middleware('permission:edit indicator units');
        Route::put('/{unit}/update', 'PerformanceIndicator\IndicatorUnitController@update')->name('indicator-units.update')->middleware('permission:edit indicator units');
        Route::delete('/{unit}', 'PerformanceIndicator\IndicatorUnitController@destroy')->name('indicator-units.destroy')->middleware('permission:delete indicator units');
    });

    Route::prefix('/guides')->middleware('permission:view guides')->group(function () {
        Route::get('/', 'PerformanceIndicator\GuideController@index')->name('guides.index')->middleware('permission:view guides');
        Route::get('/create', 'PerformanceIndicator\GuideController@create')->name('guides.create')->middleware('permission:create guides');
        Route::post('/store', 'PerformanceIndicator\GuideController@store')->name('guides.store')->middleware('permission:create guides');
        Route::get('/{guide}', 'PerformanceIndicator\GuideController@show')->name('guides.show')->middleware('permission:view guides');
        Route::get('/{guide}/edit', 'PerformanceIndicator\GuideController@edit')->name('guides.edit')->middleware('permission:edit guides');
        Route::put('/{guide}/update', 'PerformanceIndicator\GuideController@update')->name('guides.update')->middleware('permission:edit guides');
        Route::delete('/{guide}', 'PerformanceIndicator\GuideController@destroy')->name('guides.destroy')->middleware('permission:delete guides');
    });
});
