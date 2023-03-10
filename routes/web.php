<?php

use App\Http\Controllers\TestController;
use App\Http\Controllers\User\DemoController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/demo', [TestController::class, 'demo'])->name('test.demo');
Route::get('/join-discord', [DemoController::class, 'testDiscord'])->name('test.testDiscord');
Route::get('/kick', [DemoController::class, 'kick'])->name('test.kick');

Route::get('/muiltiple-page', function () {
    return view('muiltiple-page');
});

Route::get('/quiz', function () {
    return view('quiz');
});

Route::post('postDemo', [DemoController::class, 'postDemo'])->name('user.postDemo');
