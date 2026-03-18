<?php

use App\Http\Controllers\RecipeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('recipes.index');
});

// Demo Login Routes
Route::get('/login-demo', function (Request $request) {
    $request->session()->put('logged_in', true);
    return redirect()->route('recipes.index')->with('success', 'You are now logged in!');
});

Route::get('/logout-demo', function (Request $request) {
    $request->session()->forget('logged_in');
    return redirect()->route('recipes.index')->with('success', 'You have been logged out.');
});

// Public Routes - viewing recipes
Route::get('/recipes', [RecipeController::class, 'index'])->name('recipes.index');
Route::get('/recipes/{recipe}', [RecipeController::class, 'show'])->name('recipes.show');

// Protected Routes - recipe management (create, store, edit, update, delete)
Route::middleware('demo.auth')->group(function () {
    Route::get('/recipes/create', [RecipeController::class, 'create'])->name('recipes.create');
    Route::post('/recipes', [RecipeController::class, 'store'])->name('recipes.store');
    Route::get('/recipes/{recipe}/edit', [RecipeController::class, 'edit'])->name('recipes.edit');
    Route::put('/recipes/{recipe}', [RecipeController::class, 'update'])->name('recipes.update');
    Route::delete('/recipes/{recipe}', [RecipeController::class, 'destroy'])->name('recipes.destroy');
});