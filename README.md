# LiteUI 0.1.0

A small, dependency-free, server-rendered UI toolkit for PHP 7.0+. Inspired by NiceGUI's code-first composition, **not** a NiceGUI port or reactive server.

## Run the demo

```sh
php -S 127.0.0.1:8080 -t public public/router.php
```

Open http://127.0.0.1:8080. The demo validates input but does not persist it.
No Composer installation, Node.js, CDN, JavaScript or build step is required.

## Installation

Copy this repository and load `autoload.php`. Alternatively run `composer dump-autoload` and require `vendor/autoload.php`. This package is not published on Packagist.

```php
require 'autoload.php';
use LiteUI\UI;

$page = UI::page('Hello');
$page->column(function ($column) {
    $column->heading('Hello');
    $column->card(function ($card) {
        $card->label('Built entirely with PHP.');
    });
});
echo $page->render();
```

Serve `assets/liteui.css` at `/assets/liteui.css`, or configure `$page->assets('/your/assets')` before rendering.

## Features

- Fluent components, nested closure-based layouts, custom component factories.
- Page, column, row, card, headings, labels, links, inputs, forms, buttons, tables, alerts.
- RTL, responsive CSS, UTF-8 output escaping, URL/attribute restrictions.
- Automatic CSRF token fields in POST forms; explicit request verification.
- HTTP form submissions; no long-running server or browser state synchronization.

## Requirements and status

PHP >=7.0 with sessions and a browser. PHP 7 is end-of-life: compatibility is provided for legacy environments, not a recommendation to deploy an unsupported runtime. This is a **prototype**, not an audited production framework.

## Documentation

- [Components](docs/components.md)
- [Security and deployment](docs/security.md)
- [Extension guide](docs/extensions.md)

## Tests

```sh
php tests/run.php
```

MIT license. No external packages are bundled.
