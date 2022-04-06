<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MailingController;
use App\Http\Controllers\ManufacturerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get( '/', [HomeController::class, 'home'])
    ->name('index');

Route::get('/download-feed',[HomeController::class, 'downloadFeed'])
    ->name('downloadFeed');

Route::resource('mailing', MailingController::class);

Route::get('mailing/{id}/html{html}', [MailingController::class, 'createHtml'])
    ->name('mailing.html');

Route::resource('manufacturer', ManufacturerController::class);