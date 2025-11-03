# Complete Translation Guide

## Overview
Your website now has **FULL dynamic translation support** between English and German. All components are set up to use translations automatically.

## How to Add New Translations Dynamically

### Step 1: Add Translation Keys to Language Files

**Add to `resources/lang/en.json`:**
```json
{
    "Your New Text": "Your English Text Here"
}
```

**Add to `resources/lang/de.json`:**
```json
{
    "Your New Text": "Ihr deutscher Text hier"
}
```

### Step 2: Use in Your Views

**In Blade templates:**
```blade
{{ __('Your New Text') }}
```

**In PHP arrays (like services):**
```php
@php
    $items = [
        'title' => __('Your New Text'),
        'description' => __('Another translation key')
    ];
@endphp
```

**In HTML attributes (like placeholders):**
```blade
<input placeholder="{{ __('Enter name') }}" />
```

### Step 3: Language Switching

Users can switch languages using the **globe icon** in the navbar. The language preference is saved in the session and persists across page reloads.

## Components Already Translated

✅ **Navbar** - All navigation items, language switcher
✅ **Hero Section** - Title, subtitle, button
✅ **About Section** - Title, description, button
✅ **Services Section** - Title, description, all service items
✅ **Statistics Section** - All stat labels and descriptions
✅ **Contact Section** - Form labels, placeholders, button
✅ **Footer** - Quick links, contact info, copyright

## Best Practices

### 1. Use Descriptive Keys
```json
// ✅ Good
"Get in touch": "Get in touch"
"Contact us": "Contact us"

// ❌ Bad (confusing)
"text1": "Get in touch"
"text2": "Contact us"
```

### 2. Keep Keys Consistent
Use the same key for the same concept across the site:
```blade
<!-- Both use the same key -->
<h1>{{ __('Services') }}</h1>
<a href="#services">{{ __('Services') }}</a>
```

### 3. For Dynamic Content
If you have dynamic content (from database), you still need to add translations:
```php
// In your controller or component
$dynamicText = __('Your Dynamic Key');
```

### 4. Long Text
For long paragraphs, use the full text as the key:
```json
{
    "At DestroSolutions, we enable...": "At DestroSolutions, we enable..."
}
```

## Quick Reference

### Translation Helper Function
```blade
{{ __('Key') }}           <!-- Basic translation -->
{{ __('Key', [], 'de') }}  <!-- Force specific locale -->
```

### Current Language Detection
```php
app()->getLocale()  // Returns 'en' or 'de'
```

### Language Route
```php
route('locale.switch', 'en')  // Switch to English
route('locale.switch', 'de')  // Switch to German
```

## Adding Translations to New Components

### Example: Adding a New Section

1. **Create component** `resources/views/components/news.blade.php`

2. **Add translations to language files:**

   `en.json`:
   ```json
   {
       "Latest News": "Latest News",
       "Read more": "Read more"
   }
   ```

   `de.json`:
   ```json
   {
       "Latest News": "Neueste Nachrichten",
       "Read more": "Weiterlesen"
   }
   ```

3. **Use in component:**
   ```blade
   <section>
       <h2>{{ __('Latest News') }}</h2>
       <a href="#">{{ __('Read more') }}</a>
   </section>
   ```

4. **Done!** The text will automatically switch based on user's language selection.

## Troubleshooting

### Translation Not Showing?
1. Check if key exists in **both** `en.json` and `de.json`
2. Clear cache: `php artisan view:clear`
3. Verify you're using `{{ __('Key') }}` syntax correctly
4. Check browser console for errors

### Language Not Switching?
1. Verify route exists: `php artisan route:list --name=locale`
2. Check middleware is registered in `bootstrap/app.php`
3. Clear session: `php artisan session:clear`

### Adding Content to Database?
If you're storing content in a database, you have two options:

**Option 1: Store translations separately**
```php
// Database table
posts:
  - title_en
  - title_de
  - content_en
  - content_de

// In view
{{ $post->{'title_' . app()->getLocale()} }}
```

**Option 2: Use translation keys**
```php
// Database stores keys
posts:
  - title_key = "News Title Key"
  - content_key = "News Content Key"

// In view
{{ __('News Title Key') }}
```

## Automatic Translation Workflow

Once you follow this pattern:
1. Add text to language files
2. Use `{{ __('Key') }}` in views
3. Text automatically translates when user switches language
4. **No code changes needed** - just update JSON files!

## Complete Translation Checklist

When adding new content:
- [ ] Add key to `resources/lang/en.json`
- [ ] Add key to `resources/lang/de.json`
- [ ] Use `{{ __('Key') }}` in component
- [ ] Test language switching
- [ ] Verify both languages display correctly

