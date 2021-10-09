<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\Studio\MainController;
use App\Http\Controllers\User\Studio\RecordController;
//use App\Notifications\Telegram;
//use Illuminate\Support\Facades\Notification;


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
    return redirect('record');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Route::get('/', [MainController::class, 'index'])->name('main');

Route::get('/record', [RecordController::class, 'index'])->name('record');

Route::get('/record/showFormRecord', [RecordController::class, 'showFormRecord']);

Route::post('/record/addRecord', [RecordController::class, 'addRecord']);

Route::get('/record/fullcalendar/show-events', [RecordController::class, 'showEvents']);


Route::middleware(['role:admin'])->prefix('admin')->group(function () {

    Route::get('/', [App\Http\Controllers\Admin\MainController::class, 'index'])->name('mainAdmin');

    Route::get('/fullcalendar', [App\Http\Controllers\Admin\FullCalendarController::class, 'index'])->name('showCalendar');

    Route::get('/fullcalendar/show-events', [App\Http\Controllers\Admin\FullCalendarController::class, 'showEvents']);

    Route::get('/fullcalendar/copy-data', [App\Http\Controllers\Admin\FullCalendarController::class, 'copyEvents']);

    Route::get('/fullcalendar/search', [App\Http\Controllers\Admin\FullCalendarController::class, 'searchUsers']);

    Route::post('/fullcalendar/create',[App\Http\Controllers\Admin\FullCalendarController::class,'create']);

    Route::post('/fullcalendar/create-list',[App\Http\Controllers\Admin\FullCalendarController::class,'createList']);

    Route::post('/fullcalendar/update',[App\Http\Controllers\Admin\FullCalendarController::class,'update']);

    Route::post('/fullcalendar/action-with-events',[App\Http\Controllers\Admin\FullCalendarController::class,'actionWithEvents']);

    Route::post('/fullcalendar/change-time',[App\Http\Controllers\Admin\FullCalendarController::class,'changeTime']);

    Route::get('/fullcalendar/showModalAction', [App\Http\Controllers\Admin\FullCalendarController::class, 'showModalAction']);




});
//Notification::route('telegram', '599738652')
//    ->notify(new Telegram);
