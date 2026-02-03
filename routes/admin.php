<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\Auth\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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

define('COUNT', 30);
Route::group([
    //    'namespace' => 'Admin',
    'prefix' => LaravelLocalization::setLocale() . '/admin',
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'guest:admin']
], function () {
    Route::get('/login', [AuthController::class, 'get_admin_login'])->name('get.admin.login');
    Route::post('login', [AuthController::class, 'login'])->name('admin.login');
});

Route::group([
    //    'namespace' => 'Admin',
    'prefix' => LaravelLocalization::setLocale() . '/admin',
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth:admin']
], function () {
    //Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    // Profile Routes
    Route::controller(ProfileController::class)->group(function () {
        Route::get('profile', 'index')->name('admin.profile');
        Route::post('profile/update/{id}', 'update_profile')->name('admin.update.profile');
        Route::post('update-password/{id}', 'change_password')->name('admin.change.password');
    });
    Route::resource('roles', RoleController::class);

    Route::controller(AdminController::class)->group(function () {
        Route::post('admins/ajax_search', 'ajax_search')->name('admins.ajax_search');
        Route::resource('admins', AdminController::class);
    });


    //logout
    Route::get('logout', [AuthController::class, 'logout'])->name('admin.logout');

    // Route::fallback([ErrorController::class, 'error'])->name('admin.error');
});
