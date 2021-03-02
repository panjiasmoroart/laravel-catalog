<?php

use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\CatalogsController;
use App\Http\Controllers\HomeController;
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

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// jika semua controller dimasukan kedalam Route ini makan harus login terlebih dahulu untuk mengakses fiturnya
// Route::group(['middleware' => 'auth'], function () {
// masukan kedalam sini
// Route::get('/', function () {
//     return view('welcome');
// });
// }

Route::group(['middleware' => 'web'], function () {
    Auth::routes();
    Route::get('/', [CatalogsController::class, 'index']);
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::resource('/categories', CategoriesController::class);
    Route::get('ajax/categories/search', [CategoriesController::class, 'ajaxSearch']);
    Route::resource('/products', ProductsController::class);
});
