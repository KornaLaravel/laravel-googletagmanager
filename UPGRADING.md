# Upgrading

## Upgrading from 2.x to 3.x

### Breaking Changes

#### Type Annotations

The package now has 100% type coverage. This means that if you were extending any of our classes, you will need to at least add the parameter types.

Notable classes to check are:

- `Spatie\GoogleTagManager\DataLayer`
- `Spatie\GoogleTagManager\GoogleTagManager`
- `Spatie\GoogleTagManager\GoogleTagManagerMiddleware`

#### Removal of `macroPath`

The `macroPath` configuration option has been removed. If you were using this option to customize the path of the macro, you will need to now register macros in a service provider.

Example:

```php
use Spatie\GoogleTagManager\GoogleTagManager;

public function boot(): void
{
    GoogleTagManager::macro('impression', function ($product) {
        GoogleTagManager::set('ecommerce', ['product' => $product->id]);
    });
}
```
