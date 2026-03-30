@extends('layouts.app')
@section('title',$recipe->name)
@section('content')

<h3>{{ $recipe->name }}</h3>
<p><strong>Description: </strong> <br>
{{ $recipe->description }}</p>

<p><strong>Ingredients: </strong> <br>
{{ $recipe->ingredients }}</p>

<p><strong>Instructions: </strong> <br>
{{ $recipe->instructions }}</p>

@if(session('logged_in'))
<a href="{{ route('recipes.edit',$recipe)}}">Edit</a> |
<form action="{{ route('recipes.destroy', $recipe) }}" method="POST">
    @csrf
    @method('DELETE')
    <button type="submit" onclick="return confirm('Delete this recipe?')">Delete</button>
</form>
@endif
@endsection
