<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DiffController;

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

Route::get('/', [DiffController::class, 'index']);
Route::post('/diff-files', [DiffController::class, 'filesUploaded']);
Route::get('/diff/{foldername}', [DiffController::class, 'show']);
Route::get('/diff-file/{foldername}/{filename}', [DiffController::class, 'diff']);