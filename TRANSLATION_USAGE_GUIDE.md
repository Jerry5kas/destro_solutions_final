# Dynamic Translation System - Usage Guide

## Overview

The Dynamic Translation System allows you to manage translations for dynamic content (ContentItems, Categories, etc.) directly from the database. No more manual JSON file updates!

## Setup

1. **Run Migration**:
   ```bash
   php artisan migrate
   ```

2. **Update Composer Autoload**:
   ```bash
   composer dump-autoload
   ```

3. **Sync Existing Content** (optional):
   - Go to Admin Panel → Translations
   - Click "Sync All Translations" button
   - This creates translation entries for all existing content

## Automatic Machine Translation (English ➜ German)

### Enablement Steps
1. Add to `.env`:
   ```
   AUTO_TRANSLATE_ENABLED=true
   AUTO_TRANSLATE_SOURCE_LOCALE=en
   AUTO_TRANSLATE_TARGET_LOCALES=de
   TRANSLATION_PROVIDER=deepl
   DEEPL_API_KEY=your-api-key
   DEEPL_BASE_URL=https://api-free.deepl.com
   ```
2. Run a queue worker so jobs dispatched by observers are processed:
   ```bash
   php artisan queue:work
   ```

### What Happens
- `ContentItemObserver` dispatches `AutoTranslateContentItem` whenever EN content changes.
- `MachineTranslationService` calls the configured provider (DeepL placeholder included; extend as needed).
- Translated strings are stored with `is_auto = true`, enabling future manual lock/override logic.
- Seeders call the job synchronously after inserts when automation is enabled, so seed data ships pre-translated.

### Backfilling Existing Rows
Use the artisan command to translate every `ContentItem` field:
```bash
php artisan translations:auto-fill de        # Dispatch queued jobs
php artisan translations:auto-fill de --sync # Run synchronously (blocks)
```
If you omit the locale, the command uses the first entry from `AUTO_TRANSLATE_TARGET_LOCALES`.

## How It Works

### Automatic Translation Creation
When you create or update a ContentItem:
- Translation entries are automatically created in the database
- Default locale (EN) gets the original content value
- Other locales (DE, etc.) get empty values (you can fill them later)

### Translation Fields
These fields are automatically translatable for ContentItem:
- `title`
- `description`
- `prerequisites`
- `instructor_name`
- `instructor_bio`
- `certification_details`

## Usage in Views

### Option 1: Using Helper Function `t()`
```blade
{{ t($item, 'title') ?? $item->title }}
{{ t($item, 'description', 'de') }} <!-- German translation -->
```

### Option 2: Using Model Accessor (if using Translatable trait)
```blade
{{ $item->translated_title }}
{{ $item->translated_description }}
```

### Option 3: Using Model Method
```blade
{{ $item->translate('title') }}
{{ $item->translate('description', 'de') }}
```

## Admin Panel - Managing Translations

### Accessing Translation Management
1. Login to Admin Panel
2. Go to **Content Management** → **Translations**

### Editing Translations
1. Select a language from the dropdown (EN/DE)
2. Search for content if needed
3. Click **"Edit Translations"** button on any item
4. Fill in translations for all translatable fields
5. Click **"Save Translations"**

### Sync All Translations
- Click **"Sync All Translations"** button to create translation entries for all existing content
- Useful when you first set up the system or add new translatable fields
- When auto-translation is enabled, the sync creates placeholders and queued jobs will fill the translated values within seconds

## Adding New Translatable Fields

To add new translatable fields to ContentItem:

1. **Update Model** (`app/Models/ContentItem.php`):
   ```php
   protected $translatable = [
       'title',
       'description',
       'new_field', // Add here
   ];
   ```

2. **Update Admin View** (`resources/views/admin/translations/index.blade.php`):
   ```php
   $translatableFields = [
       'title', 
       'description', 
       'new_field' // Add here
   ];
   ```

3. **Run Sync**: Go to Admin → Translations → Sync All Translations

## Adding Translations to Other Models

To make any model translatable:

1. **Add Translatable Trait**:
   ```php
   use App\Support\Translatable;
   
   class YourModel extends Model
   {
       use Translatable;
       
       protected $translatable = ['title', 'description'];
   }
   ```

2. **Create Observer** (if you want auto-sync):
   ```php
   // app/Observers/YourModelObserver.php
   public function created(YourModel $model): void
   {
       app(TranslationService::class)->syncTranslations($model);
   }
   ```

3. **Register Observer** (`app/Providers/AppServiceProvider.php`):
   ```php
   YourModel::observe(YourModelObserver::class);
   ```

## Best Practices

1. **Always Provide Fallback**: Use `??` operator to fallback to original
   ```blade
   {{ t($item, 'title') ?? $item->title }}
   ```

2. **Default Locale**: Always fill default locale (usually EN) translations first

3. **Sync After Adding Fields**: When adding new translatable fields, run "Sync All Translations"

4. **Regular Sync**: If you manually edit content, translations will auto-update. For bulk imports, use "Sync All Translations"

## Troubleshooting

### Translations Not Showing
- Check if translation entries exist in database: `SELECT * FROM translations WHERE translatable_id = ?`
- Ensure current locale is set correctly: `app()->getLocale()`
- Verify model uses Translatable trait

### Auto-Sync Not Working
- Check if Observer is registered in `AppServiceProvider`
- Verify `TranslationService` is properly injected
- Check Laravel logs for errors

### Missing Translations in Admin Panel
- Run "Sync All Translations" to create entries
- Check if translatable fields are defined in model
- Verify route is registered: `php artisan route:list | grep translations`

