<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Web\PaidController;
use App\Http\Controllers\Web\SchoolController;
use App\Http\Controllers\Web\StudentController;
use App\Http\Controllers\Web\UserController;
use Illuminate\Support\Facades\Auth;
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

Auth::routes();

Route::middleware(['auth', 'userIs:director'])->group(
    function () {
        Route::get('/home', [HomeController::class, 'index'])->name('home');

        Route::prefix('users')->group(
            function () {
                route::get('/index', [UserController::class, 'index'])->name('user_index');
                route::get('/create', [UserController::class, 'create'])->name('user_create');
                route::get('/{id}/show', [UserController::class, 'show'])->name('user_show');
                route::post('/store', [UserController::class, 'store'])->name('user_store');
                route::get('/{id}/edit', [UserController::class, 'edit'])->name('user_edit');
                route::put('/{id}/update', [UserController::class, 'update'])->name('user_update');
                route::get('/{id}/delete', [UserController::class, 'destroy'])->name('user_delete');
            }
        );

        Route::prefix('schools')->group(
            function () {
                route::get('/index', [SchoolController::class, 'index'])->name('school_index');
                route::get('/create', [SchoolController::class, 'create'])->name('school_create');
                route::get('/{id}/show', [SchoolController::class, 'show'])->name('school_show');
                route::post('/store', [SchoolController::class, 'store'])->name('school_store');
                route::get('/{id}/edit', [SchoolController::class, 'edit'])->name('school_edit');
                route::put('/{id}/update', [SchoolController::class, 'update'])->name('school_update');
                route::get('/{id}/delete', [SchoolController::class, 'destroy'])->name('school_delete');
            }
        );

        Route::prefix('student')->group(
            function () {
                route::get('/{id}/index', [StudentController::class, 'index'])->name('student_index');
                route::get('/{id}/create', [StudentController::class, 'create'])->name('student_create');
                route::get('/{id}/show', [StudentController::class, 'show'])->name('student_show');
                route::get('/{id}/export', [StudentController::class, 'exportStudent'])->name('student_export');
                route::post('/{id}/store', [StudentController::class, 'store'])->name('student_store');
                route::post('/{id}/bulkstore', [StudentController::class, 'bulkStore'])->name('student_bulkStore');
                route::get('/{id}/edit', [StudentController::class, 'edit'])->name('student_edit');
                route::put('/{id}/update', [StudentController::class, 'update'])->name('student_update');
                route::get('/{id}/delete', [StudentController::class, 'destroy'])->name('student_delete');
            }
        );

        Route::prefix('fees')->group(
            function () {
                Route::get('/{id}/index', [PaidController::class, 'index'])->name('fees_index');
                Route::get('/{id}/create', [PaidController::class, 'create'])->name('fees_create');
                Route::post('/{id}/store', [PaidController::class, 'store'])->name('fees_store');
            }
        );
    }
);
