@extends('layouts.app')
@section('title', 'Recipe API Demo')
@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Recipe API Demo</h1>
    
    <div id="messageBox" class="mb-3"></div>
    
    <form id="recipeForm" class="mb-4">
        @csrf
        <input type="text" id="name" class="form-control mb-2" placeholder="Recipe Name" required>
        <textarea id="description" class="form-control mb-2" placeholder="Description" required></textarea>
        <textarea id="ingredients" class="form-control mb-2" placeholder="Ingredients" required></textarea>
        <textarea id="instructions" class="form-control mb-2" placeholder="Instructions" required></textarea>
        
        <select id="category_id" class="form-control mb-2" required>
            <option value="">Select Category</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
        
        <div class="mb-3">
            <label class="d-block mb-2"><strong>Tags:</strong></label>
            @foreach($tags as $tag)
                <div class="form-check form-check-inline">
                    <input type="checkbox" class="form-check-input tag-checkbox" value="{{ $tag->id }}" id="tag_{{ $tag->id }}">
                    <label class="form-check-label" for="tag_{{ $tag->id }}">{{ $tag->name }}</label>
                </div>
            @endforeach
        </div>
        
        <button type="submit" class="btn btn-primary">Add Recipe</button>
    </form>
    
    <div id="recipeList"></div>
</div>

<script>
    // Fetch and display all recipes
    async function loadRecipes() {
        try {
            const response = await fetch('/api/recipes');
            const result = await response.json();
            
            if (result.success) {
                displayRecipes(result.data);
            }
        } catch (error) {
            console.error('Error loading recipes:', error);
        }
    }

    // Display recipes in the list
    function displayRecipes(recipes) {
        const recipeList = document.getElementById('recipeList');
        
        if (recipes.length === 0) {
            recipeList.innerHTML = '<p class="text-muted">No recipes yet. Create one above!</p>';
            return;
        }
        
        recipeList.innerHTML = recipes.map(recipe => `
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">${recipe.name}</h5>
                    <p class="card-text">${recipe.description}</p>
                    <p><strong>Category:</strong> ${recipe.category.name}</p>
                    <p><strong>Tags:</strong> ${recipe.tags.map(t => t.name).join(', ') || 'None'}</p>
                    <p><strong>Ingredients:</strong> ${recipe.ingredients}</p>
                    <p><strong>Instructions:</strong> ${recipe.instructions}</p>
                    <button class="btn btn-sm btn-danger" onclick="deleteRecipe(${recipe.id})">Delete</button>
                </div>
            </div>
        `).join('');
    }

    // Handle form submission
    document.getElementById('recipeForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        
        // Get selected tags
        const selectedTags = Array.from(document.querySelectorAll('.tag-checkbox:checked'))
            .map(checkbox => parseInt(checkbox.value));
        
        const formData = {
            name: document.getElementById('name').value,
            description: document.getElementById('description').value,
            ingredients: document.getElementById('ingredients').value,
            instructions: document.getElementById('instructions').value,
            category_id: parseInt(document.getElementById('category_id').value),
            tags: selectedTags
        };
        
        try {
            const response = await fetch('/api/recipes', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: JSON.stringify(formData)
            });
            
            const result = await response.json();
            
            const messageBox = document.getElementById('messageBox');
            
            if (response.ok) {
                messageBox.innerHTML = `<div class="alert alert-success">✓ Recipe created successfully!</div>`;
                document.getElementById('recipeForm').reset();
                loadRecipes();
            } else {
                if (result.errors) {
                    let errorsHtml = '<ul>';
                    Object.values(result.errors).forEach(messages => {
                        messages.forEach(message => {
                            errorsHtml += `<li>${message}</li>`;
                        });
                    });
                    errorsHtml += '</ul>';
                    messageBox.innerHTML = `<div class="alert alert-danger"><strong>Validation Errors:</strong>${errorsHtml}</div>`;
                } else {
                    messageBox.innerHTML = `<div class="alert alert-danger">✗ Error: ${result.message || 'Failed to create recipe'}</div>`;
                }
            }
        } catch (error) {
            document.getElementById('messageBox').innerHTML = `<div class="alert alert-danger">✗ Error: ${error.message}</div>`;
            console.error('Error creating recipe:', error);
        }
    });

    // Delete recipe
    async function deleteRecipe(id) {
        if (!confirm('Are you sure you want to delete this recipe?')) return;
        
        try {
            const response = await fetch(`/api/recipes/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                }
            });
            
            const result = await response.json();
            
            const messageBox = document.getElementById('messageBox');
            if (response.ok) {
                messageBox.innerHTML = `<div class="alert alert-success">✓ ${result.message}</div>`;
                loadRecipes();
            } else {
                messageBox.innerHTML = `<div class="alert alert-danger">✗ Failed to delete recipe</div>`;
            }
        } catch (error) {
            console.error('Error deleting recipe:', error);
        }
    }

    // Load recipes on page load
    loadRecipes();
</script>
@endsection
