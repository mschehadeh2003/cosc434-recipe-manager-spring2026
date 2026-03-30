<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\RecipeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group.
|
*/

// Public API endpoints for reading recipes (no authentication required)
Route::apiResource('recipes', RecipeController::class)
    ->only(['index', 'show'])
    ->names('api.recipes');

// Protected API endpoints for modifying recipes (requires demo.auth middleware)
Route::middleware('demo.auth')->group(function () {
    Route::apiResource('recipes', RecipeController::class)
        ->only(['store', 'update', 'destroy'])
        ->names('api.recipes');
});

/*
Routes with protection:
GET    /api/recipes              - List all recipes (index) - PUBLIC
POST   /api/recipes              - Create new recipe (store) - PROTECTED
GET    /api/recipes/{recipe}     - Get single recipe (show) - PUBLIC
PUT    /api/recipes/{recipe}     - Update recipe (update) - PROTECTED
DELETE /api/recipes/{recipe}     - Delete recipe (destroy) - PROTECTED
*/
