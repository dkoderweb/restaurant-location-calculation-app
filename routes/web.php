<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RestaurantController;


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
Route::get('/save-create', [RestaurantController::class, 'create'])->name('restaurants.create');
Route::post('/save-restaurant', [RestaurantController::class, 'save'])->name('save-restaurant');
Route::get('/', [RestaurantController::class, 'index']);
