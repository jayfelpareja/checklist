<?php

use App\Http\Controllers\ChecklistController;
use Illuminate\Support\Facades\Route;

// 1. New Overview Dashboard Route (Add this line)
Route::get('/dashboard', [ChecklistController::class, 'dashboard'])->name('checklist.dashboard');

// Existing Routes
Route::get('/', [ChecklistController::class, 'index'])->name('checklist.index');
Route::post('/project', [ChecklistController::class, 'store'])->name('checklist.store');
Route::post('/item/{id}/toggle', [ChecklistController::class, 'toggle'])->name('checklist.toggle');
Route::delete('/project/{project_url}', [ChecklistController::class, 'destroy'])->name('checklist.destroy');

Route::get('/checklist', [ChecklistController::class, 'index'])->name('checklist.index');
Route::post('/checklist', [ChecklistController::class, 'store'])->name('checklist.store');
Route::post('/checklist/toggle/{id}', [ChecklistController::class, 'toggle'])->name('checklist.toggle');
Route::delete('/checklist/{url}', [ChecklistController::class, 'destroy'])->name('checklist.destroy');

Route::get('/clear-cache', function() {
    Artisan::call('config:cache');
    Artisan::call('view:cache');
    Artisan::call('route:cache');
    return "Laravel is fully optimized and cached!";
});