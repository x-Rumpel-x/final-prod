<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin/login', function () {
    return view('admin.auth.auth');
})->name('login');
Route::post('/admin/login', [\App\Http\Controllers\admin\AuthController::class, 'login']
)->name("auth.perform");

Route::get('/registration', function (){
    return view('public.auth.registration');
});
Route::post('/registration', [\App\Http\Controllers\admin\AuthController::class, 'registration']);

Route::get('/login', function (){
    return view("public.auth.auth");
})->name('public.auth');
Route::post('/login', [\App\Http\Controllers\admin\AuthController::class, 'login']
)->name('public.auth.perform');

Route::get('/recovery', function (){
    return view('public.auth.recovery');
})->name('recovery');
Route::post('/recovery', [\App\Http\Controllers\admin\AuthController::class, 'recovery']);

Route::group(['middleware' => ['auth']], function () {
    Route::get('/logout', [\App\Http\Controllers\LogoutController::class, 'logout']
    )->name("logout");

    Route::prefix('admin')->middleware([])->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\admin\DashboardController::class, 'index']
        )->name('dashboard');

        Route::controller(\App\Http\Controllers\admin\ProfileController::class)->group(function () {
            Route::get('/profile/{id?}', 'index')->name('profile');
            Route::post('/profile/save', 'save')->name('profile.save');
            Route::post('/profile/upload-avatar', 'uploadAvatar');
        });

        Route::controller(\App\Http\Controllers\admin\UsersController::class)->group(function () {
            Route::get('/users', 'index')->name('users');
        });
    });
});

//TODO: доделать города. парки. кнопку выход на главной(пользователей). шаблон для сброса пароля. морду сайту. добавить на регу мыло(+ в аякс). ДО ПЯТНИЦЫ
