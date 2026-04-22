<?php

use Illuminate\Support\Facades\Route;
use Masmaleki\ZohoAllInOne\Http\Controllers\Auth\ZohoTokenCheck;


Route::group([
    'middleware' => ['web']
], function () {
    Route::any('zoho_oauth2callback/{organizationId?}', [ZohoTokenCheck::class, 'saveTokens'])->name('zoho.save.tokens');

});

Route::group([
    'middleware' => config('zoho-one.middleware', ['web']),
    'domain' => config('zoho-one.domain', null),
    'prefix' => config('zoho-one.prefix'),
], function () {
    Route::prefix('zoho')->group(function () {
        Route::get('/application/register', [ZohoTokenCheck::class, 'applicationRegister'])->name('zoho.application.register');
    });
});
