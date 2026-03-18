# Recipe Manager - Middleware Protection Lab

**Student:** Mohamad Chehade  
**GitHub:** [@mschehadeh2003](https://github.com/mschehadeh2003)  
**Course:** COSC 434 - Web Development II  
**Lab Title:** Protecting the Recipe App Using Middleware

## What Was Implemented

This lab implements middleware-based access control for a Laravel recipe management application. A custom middleware (`EnsureUserIsLoggedIn`) was created to protect recipe management operations (create, store, edit, update, delete) by checking a session flag. Public viewing routes (list and show) remain unprotected. The middleware was registered with the alias `'demo.auth'` in `bootstrap/app.php` and applied to all 5 protected routes using a route group for maintainability. Two demo routes (`/login-demo` and `/logout-demo`) simulate login/logout functionality using session storage. The UI was enhanced with login status display, flash messages for user feedback, and hidden management buttons for non-authenticated users to improve the testing experience.

## Testing

**Public Access (Logged Out)**
- ✅ Can view recipe list and single recipes
- ✅ Management buttons are hidden

**Protected Access (Logged Out)**
- ✅ Cannot access create, edit, or delete - redirected to login with warning

**Protected Access (Logged In)**
- ✅ Can demo login, access all management routes, and create/edit/delete recipes
- ✅ After logout, protected access is blocked again

