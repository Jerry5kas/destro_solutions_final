# Language Switching Guide

## Overview
The application supports dynamic language switching between English (en) and German (de).

## How It Works

### Current Implementation
1. **Language Files**: Located in `resources/lang/`
   - `en.json` - English translations
   - `de.json` - German translations

2. **Language Switcher**: Available in the navbar (globe icon)
   - Click to open dropdown
   - Select English or Deutsch
   - Page reloads with selected language

3. **Session Storage**: Language preference is stored in session (`app_locale`)

## Using Translations in Views

### Basic Usage
```blade
{{ __('Home') }}
{{ __('Services') }}
{{ __('Contact Us') }}
```

### In Navigation Items
Already implemented in `navbar.blade.php`:
```php
['label' => __('Home'), 'href' => '#'],
['label' => __('Services'), 'href' => '#services'],
```

### In Components
Use the `__()` helper function anywhere:
```blade
<h1>{{ __('Welcome') }}</h1>
<p>{{ __('Description text') }}</p>
```

## Adding New Translations

### Step 1: Add to English File
Edit `resources/lang/en.json`:
```json
{
    "Your New Key": "Your English Text",
    "Another Key": "Another English Text"
}
```

### Step 2: Add to German File
Edit `resources/lang/de.json`:
```json
{
    "Your New Key": "Ihr deutscher Text",
    "Another Key": "Weiterer deutscher Text"
}
```

### Step 3: Use in Your Views
```blade
{{ __('Your New Key') }}
{{ __('Another Key') }}
```

## Technical Details

### Route
- **URL**: `/locale/{locale}`
- **Name**: `locale.switch`
- **Method**: GET
- **Supported locales**: `en`, `de`

### Middleware
- **Class**: `App\Http\Middleware\SetLocale`
- **Location**: `app/Http/Middleware/SetLocale.php`
- **Registered in**: `bootstrap/app.php`

### How Language is Detected
1. Checks session for `app_locale`
2. Falls back to `config('app.locale')` (default: 'en')
3. Sets locale using `App::setLocale($locale)`

## Testing Language Switching

1. Visit the homepage
2. Click the globe icon in the navbar
3. Select "Deutsch" - page should reload with German text
4. Select "English" - page should reload with English text
5. Refresh the page - language preference should persist

## Current Translations Available

Check `resources/lang/en.json` and `resources/lang/de.json` for all available translation keys:

- Navigation items (Home, Services, Products, etc.)
- UI elements (Search, Language, etc.)
- Common phrases
- And more...

## Troubleshooting

### Language Not Changing?
1. Check if route exists: `php artisan route:list --name=locale`
2. Verify middleware is registered in `bootstrap/app.php`
3. Clear cache: `php artisan cache:clear` and `php artisan config:clear`
4. Check browser session storage

### Translation Not Showing?
1. Verify the key exists in both `en.json` and `de.json`
2. Check for typos in the translation key
3. Clear view cache: `php artisan view:clear`
4. Ensure you're using `__('Key')` syntax correctly

