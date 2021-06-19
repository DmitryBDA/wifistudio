<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\Studio\MainController;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/', [MainController::class, 'index'])->name('main');

Route::middleware(['role:admin'])->prefix('admin')->group(function () {

    Route::get('/', [App\Http\Controllers\Admin\MainController::class, 'index'])->name('mainAdmin');

    Route::get('fullcalendar', [App\Http\Controllers\Admin\FullCalendarController::class, 'index'])->name('showCalendar');

    Route::get('fullcalendar/show-events', [App\Http\Controllers\Admin\FullCalendarController::class, 'showEvents']);
});
