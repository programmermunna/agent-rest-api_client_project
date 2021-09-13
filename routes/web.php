<?php

// use App\Http\Controllers\LocaleController;
// use App\Http\Controllers\Api\v1\MemberController;
// use App\Http\Controllers\Backend\BonusController;

/*
 * Global Routes
 *
 * Routes that are used between both frontend and backend.
 */

// Switch between the included languages
Route::get('/', function(){
 return json_encode('success');
});

