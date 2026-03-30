<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $recipes = Recipe::with(['category', 'tags'])->get();
        return response()->json([
            'success' => true,
            'message' => 'Recipes retrieved successfully',
            'data' => $recipes
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'ingredients' => 'required|string',
                'instructions' => 'required|string',
                'category_id' => 'required|exists:categories,id',
                'tags' => 'nullable|array',
                'tags.*' => 'exists:tags,id',
            ]);

            $recipe = Recipe::create([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'ingredients' => $validated['ingredients'],
                'instructions' => $validated['instructions'],
                'category_id' => $validated['category_id'],
            ]);

            $recipe->tags()->attach($validated['tags'] ?? []);
            $recipe->load(['category', 'tags']);

            return response()->json([
                'message' => 'Recipe created successfully.',
                'recipe' => $recipe
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating recipe',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Recipe $recipe)
    {
        $recipe->load(['category', 'tags']);

        return response()->json([
            'success' => true,
            'message' => 'Recipe retrieved successfully',
            'data' => $recipe
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Recipe $recipe)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'ingredients' => 'required|string',
                'instructions' => 'required|string',
                'category_id' => 'required|exists:categories,id',
                'tags' => 'nullable|array',
                'tags.*' => 'exists:tags,id',
            ]);

            $recipe->update([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'ingredients' => $validated['ingredients'],
                'instructions' => $validated['instructions'],
                'category_id' => $validated['category_id'],
            ]);

            $recipe->tags()->sync($validated['tags'] ?? []);
            $recipe->load(['category', 'tags']);

            return response()->json([
                'message' => 'Recipe updated successfully.',
                'recipe' => $recipe
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating recipe',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Recipe $recipe)
    {
        $recipe->delete();

        return response()->json([
            'message' => 'Recipe deleted successfully.'
        ]);
    }
}
