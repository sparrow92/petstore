<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetController;

Route::get('pets', [PetController::class, 'index'])->name('pets.index');
Route::post('pets', [PetController::class, 'store'])->name('pets.store');
Route::get('pets/{id}', [PetController::class, 'show'])->name('pets.show');
Route::get('/pets/{id}/edit', [PetController::class, 'edit'])->name('pets.edit');
Route::put('/pets/{id}', [PetController::class, 'update'])->name('pets.update');
Route::delete('/pets/{id}', [PetController::class, 'delete'])->name('pets.delete');


