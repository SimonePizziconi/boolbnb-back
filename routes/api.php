<?php

use App\Http\Controllers\Api\PageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/apartments', [PageController::class, 'index']);
// Route::get('/apartments-search', [PageController::class, 'search']);
// Route::get('/apartment/{slug}', [PageController::class, 'show']);

