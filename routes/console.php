<?php

use Illuminate\Foundation\Inspiring;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
 */

//Artisan::command('inspire', function () {
//    $this->comment(Inspiring::quote());
//})->describe('Display an inspiring quote');

Artisan::command('migrate', function () {
    $this->comment("Sorry, You are not allowed to do this!\nBy : Cikatech\nTime : " . now());
})->describe('Override default command.');
Artisan::command('migrate:fresh', function () {
    $this->comment("Sorry, You are not allowed to do this!\nBy : Cikatech\nTime : " . now());
})->describe('Override default command.');
Artisan::command('migrate:refresh', function () {
    $this->comment("Sorry, You are not allowed to do this!\nBy : Cikatech\nTime : " . now());
})->describe('Override default command.');
Artisan::command('db:seed', function () {
    $this->comment("Sorry, You are not allowed to do this!\nBy : Cikatech\nTime : " . now());
})->describe('Override default command.');
