# Layout Component

A reusable Blade layout component with all dependencies included.

## Location
`resources/views/components/layout.blade.php`

## Features

- ✅ All Google Fonts (Orbitron, Poppins, Inter)
- ✅ Tailwind CSS configuration
- ✅ GSAP animation library
- ✅ Vite assets integration
- ✅ Global font assignments
- ✅ Header/navbar styles included
- ✅ Slider/hero styles included
- ✅ Customizable via props and stacks

## Usage

### Basic Usage

```blade
<x-layout>
    <h1>Welcome</h1>
    <p>Your content here...</p>
</x-layout>
```

### With Custom Title

```blade
<x-layout title="My Custom Page Title">
    <h1>Welcome</h1>
    <p>Your content here...</p>
</x-layout>
```

### With Custom Styles

```blade
<x-layout>
    <h1>Welcome</h1>
    
    @push('styles')
    <style>
        .custom-class {
            color: blue;
        }
    </style>
    @endpush
</x-layout>
```

### With Custom Scripts

```blade
<x-layout>
    <h1>Welcome</h1>
    
    @push('scripts')
    <script>
        console.log('Page loaded');
        // Your custom JavaScript here
    </script>
    @endpush
</x-layout>
```

### With Additional Head Content

```blade
<x-layout>
    <h1>Welcome</h1>
    
    @push('head')
    <meta name="description" content="My page description">
    <link rel="canonical" href="https://example.com">
    @endpush
</x-layout>
```

## Available Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `title` | string | `'Destrsolutions - Bringing SDV to Life'` | Page title |

## Available Stacks

| Stack | Location | Description |
|-------|----------|-------------|
| `styles` | `<style>` tag | Add custom CSS styles |
| `head` | `<head>` section | Add meta tags, links, etc. |
| `scripts` | Before `</body>` | Add custom JavaScript |

## Included Dependencies

1. **Google Fonts**
   - Orbitron (for logos)
   - Poppins (for headings)
   - Inter (for body/content)

2. **Tailwind CSS**
   - CDN version
   - Custom configuration
   - Custom colors, shadows, fonts

3. **GSAP**
   - Animation library v3.12.5

4. **Vite Assets**
   - CSS: `resources/css/app.css`
   - JS: `resources/js/app.js`

## Font Usage

- **Logo**: Automatically uses Orbitron (via `#logoInBar`, `.nav-logo` selectors)
- **Headings**: All `h1-h6` automatically use Poppins
- **Body**: All body content uses Inter

You can also use Tailwind classes:
- `font-orbitron` - Orbitron font
- `font-poppins` - Poppins font  
- `font-inter` - Inter font

## Example Files

See `resources/views/example-layout.blade.php` for a complete example.

