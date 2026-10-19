# Custom components

Extend `LiteUI\Core\Component` (or `Container`) or register a named factory:

```php
use LiteUI\UI;
use LiteUI\Core\Component;

UI::register('badge', function ($props) {
    return new Component('span', $props['text'], ['class' => 'lu-alert']);
});
$page->add(UI::component('badge', ['text' => 'Ready']));
```

Factories must return a Component. Provide your own CSS in the host application. Custom renderers are responsible for preserving escaping and security. There is no plugin discovery, dependency injection container or automatic asset bundling.
