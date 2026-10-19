# Component API

All text and attribute values are HTML-escaped. `render()` returns a string; send it once the page is fully built. `add()` returns the inserted child, not its parent.

## Page

`UI::page($title)`, `lang('en')`, `rtl(true)`, `assets('/assets')`.

## Layout

`column($callback = null)`, `row($callback = null)`, `card($callback = null)` return containers. Callbacks receive the new container. Every container supports the methods below.

## Content

- `heading($text, $level = 1)`; levels 1–6.
- `label($text)` renders a paragraph, not an HTML form label.
- `link($text, $url)`; relative URLs and http/https/mailto/tel schemes.
- `alert($text, $kind = 'info')`; info/success/error.
- `table($columns, $rows)`; columns is an associative field-to-label map; rows are associative arrays of scalar cell values. No pagination or sorting is included.

```php
$page->table(['name' => 'Name'], [['name' => 'Alice']]);
```

## Forms

`form($action, $callback = null, $method = 'post')` supports GET and POST only. Build forms before emitting output because POST forms start a session.

```php
$page->form('/save', function ($form) {
    $form->input('email', 'Email')->type('email')->required();
    $form->button('Save');
});
```

Inputs: `type()`, `value()`, `required()`, `placeholder()`, `controlAttr($name, $value)`.
Supported types: text, email, password, number, date, tel, url, search.
`attr()` on Input targets its wrapping label; `controlAttr()` targets the actual input.

Buttons submit their enclosing form. There are no PHP click callbacks, `submit('/url')` convenience method, AJAX or WebSocket handlers in this release. Set the endpoint on `form()` instead.

## Styling and custom attributes

`class('my-class')`, `attr('aria-label', 'Description')`, `attr('disabled', true)`.
False/null attributes are omitted. Inline event attributes, inline styles and srcdoc are rejected.
