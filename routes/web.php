<?php

use App\Http\Controllers\Controller;
use App\Http\Livewire\ShowUser;
use App\Http\Livewire\CrearUser;
use App\Http\Livewire\ShowPosts;
use Spatie\Permission\Models\Role;
use App\Http\Livewire\PanelControl;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Middlewares\RoleMiddleware;

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

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

//Solo el que tenga rol de ADMIN 
Route::middleware([
    'auth:sanctum', 
    config('jetstream.auth_session'), 
    'verified', RoleMiddleware::class . ':admin'])->group(function () {
    Route::get('/panel-control', PanelControl::class)->name('panel-control');
    Route::get('/usuarios', ShowUser::class)->name('admin.show-user');
    Route::get('/posts/{type}', ShowPosts::class)->name('show-posts');
});



