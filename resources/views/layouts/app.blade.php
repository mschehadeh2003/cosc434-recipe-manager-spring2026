<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Recipe Manager')</title>
</head>
<body>
    <h2> Recipe Manager</h2>

    <nav>
        <a href="{{ route('recipes.index') }}">All Recipes</a>
        @if(session('logged_in'))
        <a href="{{ route('recipes.create') }}">Create Recipe</a>
        @endif
        |
        <!-- Demo Login/Logout Links for Testing -->
        @if(session('logged_in'))
            <strong style="color: green;">✓ Logged In</strong>
            <a href="/logout-demo">Logout Demo</a>
        @else
            <strong style="color: red;">✗ Not Logged In</strong>
            <a href="/login-demo">Login Demo</a>
        @endif
    </nav>
    
    <!-- Flash Messages -->
    @if(session('success'))
    <div style="background-color: #d4edda; color: #155724; padding: 12px; margin: 10px 0; border-radius: 4px;">
        ✓ {{ session('success') }}
    </div>
    @endif
    @if(session('warning'))
    <div style="background-color: #fff3cd; color: #856404; padding: 12px; margin: 10px 0; border-radius: 4px;">
        ⚠ {{ session('warning') }}
    </div>
    @endif
    
    @yield('content')

</body>
</html>