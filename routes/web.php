<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Admin\TrainerController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

require __DIR__.'/auth.php';

// Главный маршрут (перенаправление)
Route::get('/', function () {
    if (Auth::check()) {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.reports.index');
        } 
        return redirect()->route('reports.index');
    }
    return redirect()->route('login');
})->name('home');

// Общие маршруты для аутентифицированных пользователей
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Маршруты для тренеров
Route::middleware(['auth', \App\Http\Middleware\CheckRole::class.':trainer'])->group(function () {
    Route::prefix('reports')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/create', [ReportController::class, 'create'])->name('reports.create');
        Route::post('/', [ReportController::class, 'store'])->name('reports.store');
        Route::get('/{report}', [ReportController::class, 'show'])->name('reports.show');
        Route::get('/{report}/edit', [ReportController::class, 'edit'])->name('reports.edit');
        Route::put('/{report}', [ReportController::class, 'update'])->name('reports.update');
        Route::delete('/{report}', [ReportController::class, 'destroy'])->name('reports.destroy');
    });
});

// Маршруты для администраторов
Route::prefix('admin')->middleware(['auth', \App\Http\Middleware\CheckRole::class.':admin'])->group(function () {
    // Управление тренерами 
    Route::resource('trainers', TrainerController::class)
         ->names([
             'index' => 'admin.trainers.index',
             'create' => 'admin.trainers.create',
             'store' => 'admin.trainers.store',
             'show' => 'admin.trainers.show',
             'edit' => 'admin.trainers.edit',
             'update' => 'admin.trainers.update',
             'destroy' => 'admin.trainers.destroy'
         ]);

    // Просмотр всех отчетов
    Route::get('/reports', [ReportController::class, 'adminIndex'])->name('admin.reports.index');
    Route::post('/reports/{report}/approve', [ReportController::class, 'approve'])
         ->name('admin.reports.approve');
});