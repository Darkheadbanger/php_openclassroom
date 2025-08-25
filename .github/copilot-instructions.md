# PHP Recipe Sharing Platform - AI Coding Instructions

## Architecture Overview

This is a **component-based PHP application** following MVC-inspired patterns with a **security-first approach**. The codebase uses reusable form components (similar to Angular) and modular CRUD operations.

### Key Directories
- `CRUD/` - Database operations (users/, recettes/)
- `views/forms/` - Reusable form components  
- `assets/protection/` - Security modules (CSRF, CSP, honeypot)
- `authentification/` - Centralized auth verification
- `config/` - Database connection and rate limiting

## Component System

Forms use **context variables** passed from parent pages:
```php
// Parent page sets context
$FORM_MODE = 'create';  // or 'edit'
$FORM_RECIPE_ID = null; // or actual ID
include './views/forms/recipe-form.php';

// Form component reads context
$isEditMode = isset($FORM_MODE) && $FORM_MODE === 'edit';
```

## Security Patterns

**Every form must include these protections:**
```php
include_once __DIR__ . '/assets/protection/protectionCsrfAndHoneypot.php';
// Generates CSRF token, checks honeypot

// In form HTML:
<input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
<input type="text" name="honeypot" style="display:none;" tabindex="-1" autocomplete="off">
```

**Authentication verification pattern:**
```php
include_once __DIR__ . '/authentification/authentificationVerif.php';
// Dies if not logged in or invalid CSRF on POST
```

## Database Patterns

**Connection:** Always use `getDatabaseConnection()` from `config/databaseConnect.php`

**CRUD structure:**
- `fetch*.php` - Read operations, return arrays like `$recipesFetched`
- `add*.php` - Create operations with validation and rate limiting
- `update*.php` - Modify operations
- `delete*.php` - Remove operations

**Rate limiting:** Use `checkAddRecipeLimit($userId, $action, $maxAttempts, $timeWindow)` for write operations.

## File Organization

**Bootstrap styling:** All pages use Bootstrap 5 CDN with CSP headers allowing `cdn.jsdelivr.net`

**Include paths:** Use `__DIR__` for reliable relative paths:
```php
include_once __DIR__ . '/../../config/databaseConnect.php';
```

**Naming conventions:**
- `modifiedRecipe.php` (not `modifiedReicipe.php`) 
- Form actions point to `CRUD/*/add*.php` or `CRUD/*/update*.php`

## Session Management

Standard session pattern with persistent cookies:
```php
$_SESSION['user'] = ['email' => $email, 'logged_in' => true];
setcookie('LOGGED_USER', $email, ['expires' => time() + 365*24*3600, 'secure' => true, 'httponly' => true]);
```

## Development Workflow

**Database setup:** Run `php setup_table_BDD/setup_database.php` to initialize tables and test data.

**Error handling:** Use `error_log()` for logging, redirect with error messages in URL params.

**Validation:** Server-side validation is mandatory, client-side Bootstrap validation is supplementary.

This architecture prioritizes security, reusability, and maintainability over simple procedural PHP patterns.
