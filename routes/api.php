<?php

use App\Http\Controllers\Api\{ChecklistController, ChecklistItemController, RegisterController, LoginController, LogoutController, UserController};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/register', RegisterController::class)->name('register');
Route::post('/login', LoginController::class)->name('login');

Route::middleware(['auth:api'])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');

    Route::post('/logout', LogoutController::class)->name('logout');

    Route::get('/checklists', [ChecklistController::class, 'index'])->name('checklist.index');
    Route::post('/checklists', [ChecklistController::class, 'store'])->name('checklist.store');
    Route::delete('/checklists/{checklistId}', [ChecklistController::class, 'destroy'])->name('checklist.destroy');

    Route::get('/checklist/{checklistId}/items', [ChecklistItemController::class, 'index'])
        ->name('checklist.items.index');

    Route::post('/checklist/{checklistId}/items', [ChecklistItemController::class, 'store'])
        ->name('checklist.items.store');

    Route::get('/checklist/{checklistId}/items/{checklistItemId}', [ChecklistItemController::class, 'show'])
        ->name('checklist.items.show');

    Route::put('/checklist/{checklistId}/items/{checklistItemId}', [ChecklistItemController::class, 'update'])
        ->name('checklist.items.update');

    Route::delete('/checklist/{checklistId}/items/{checklistItemId}', [ChecklistItemController::class, 'destroy'])
        ->name('checklist.items.destroy');
});
