# Laravel Slug I18n

A professional Laravel package to generate multilingual UTF-8 slugs with smart, configurable skipping of transliteration for specific locales (like Arabic, Farsi, Urdu, etc.), while keeping Laravel’s original Str::slug() behavior intact.

---

## 🚀 Features
- Generate clean, SEO-friendly slugs for any language
- Skip transliteration automatically for configurable locales (e.g., ar, fa, ur)
- Fully compatible with Laravel’s Str helper
- Supports Laravel 9, 10, 11, 12, 13
- Works with spatie/laravel-sluggable out of the box
- Zero config (but highly configurable if needed)
- Auto-discovered (no need to manually register service provider)
- Publishable config file for easy customization
- Supports custom dictionary replacements and force skip

---

## 📦 Installation

```bash
composer require developvi/laravel-slug-i18n
```

---

## ⚙️ Configuration

You can publish the config file with:

```bash
php artisan vendor:publish --tag=slug-i18n-config
```

### .env Options
- **SLUG_I18N_ENABLED**: Enable or disable the package (default: true)
- **SLUG_I18N_SKIP_LOCALES**: Comma-separated list of locales to skip transliteration for (e.g., `ar,fa,ur`)

Example:
```
SLUG_I18N_ENABLED=true
SLUG_I18N_SKIP_LOCALES=ar,fa,ur
```

### config/slug-i18n.php
You can also edit the config file directly for advanced control:
```php
return [
    'enabled' => env('SLUG_I18N_ENABLED', true),
    'skip_locales' => [
        ...array_filter(
            explode(',', (string) env('SLUG_I18N_SKIP_LOCALES', ''))
        ),
    ],
];
```

---

## 🧑‍💻 Usage

### Basic Usage
Use the new macro `Str::slugI18n` for full control:

```php
use Illuminate\Support\Str;

// Will skip transliteration for Arabic if configured
$slug = Str::slugI18n('مثال على نص عربي', '-', 'ar'); // Output: مثال-على-نص-عربي

// Will transliterate for English
$slug = Str::slugI18n('Example English Text', '-', 'en'); // Output: example-english-text
```

### Macro Signature
```php
Str::slugI18n(
    string $title,
    string $separator = '-',
    string $language = 'en',
    array $dictionary = ['@' => 'at'],
    bool $forceSkip = false
): string
```

- **$title**: The string to slugify
- **$separator**: Word separator (default: '-')
- **$language**: Language/locale code (e.g., 'ar', 'en', ...)
- **$dictionary**: Custom replacements (e.g., ['@' => 'at'])
- **$forceSkip**: If true, always skip transliteration regardless of config

### Advanced Usage

```php
// Custom dictionary and force skip
$slug = Str::slugI18n('Laravel@10 ❤️', '-', 'en', ['@' => 'at', '❤️' => 'love'], true); // laravel-at-10-love

// Force skip transliteration for any language
$slug = Str::slugI18n('مثال على نص عربي', '-', 'en', [], true); // مثال-على-نص-عربي
```

---

## 🔗 spatie/laravel-sluggable Integration

When [spatie/laravel-sluggable](https://github.com/spatie/laravel-sluggable) v4+ is installed, the package swaps its `generate_slug` action for `GenerateSlugI18nAction`, so every `HasSlug` model slugifies through `SlugI18n`. Uniqueness, suffixes and all other spatie options keep working as before.

Set the slug language on the model and add it to `skip_locales`:

```php
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Product extends Model
{
    use HasSlug;

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->usingLanguage('ar');
    }
}
```

```
SLUG_I18N_SKIP_LOCALES=ar
```

```php
Product::create(['name' => 'سماعات لاسلكية'])->slug; // سماعات-لاسلكية
Product::create(['name' => 'سماعات لاسلكية'])->slug; // سماعات-لاسلكية-1
```

If your app already sets its own `sluggable.actions.generate_slug`, it is left untouched. To turn the integration off:

```
SLUG_I18N_SPATIE_SLUGGABLE=false
```

---

## 🧪 Testing

To run the package tests:

```bash
composer install
./vendor/bin/phpunit
```

---

## 📝 License

MIT

---

## 👤 Author

**Eslam El Sherif**  
[dev@eslamelsherif.com](mailto:dev@eslamelsherif.com)

---

## 💡 Example in Laravel Route

```php
use Illuminate\Support\Str;

Route::get('/slug', function () {
    $slug = Str::slugI18n('مرحبا بك', forceSkip: true);
    return $slug; // Output: مرحبا-بك
});
```

---

## 🤝 Contributing

Pull requests are welcome! For major changes, please open an issue first to discuss what you would like to change. 