<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ApartmentsController;
use App\Http\Controllers\Admin\SponsorshipController;
use App\Http\Controllers\Admin\MessaggesController;
use App\Http\Controllers\Guest\PageController;
use App\Http\Controllers\ProfileController;
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

Route::get('/', [PageController::class, 'index'])->name('home');

Route::middleware(['auth', 'verified'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('index');
        Route::get('/apartments/trash', [ApartmentsController::class, 'trash'])->name('apartments.trash');
        Route::patch('/apartments/{apartment}/restore', [ApartmentsController::class, 'restore'])->name('apartments.restore');
        Route::delete('/apartments/{apartment}/delete', [ApartmentsController::class, 'delete'])->name('apartments.delete');
        Route::get('/sponsorships/payment', [SponsorshipController::class, 'showPaymentForm'])->name('sponsorships.payment');
        Route::post('/sponsorships/process', [SponsorshipController::class, 'processPayment'])->name('sponsorships.process');
        Route::get('/messagges', [MessaggesController::class, 'showMessagges'])->name('messagges.index');
        Route::resource('apartments', ApartmentsController::class);
    });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
