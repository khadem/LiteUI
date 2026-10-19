# Security and deployment

## Request lifecycle

LiteUI renders HTML. Your application owns routing, authentication, authorization, storage, validation, rate limits, uploads and error handling. It is not an API framework or HTML sanitizer.

POST forms contain `_csrf` automatically, but **handlers must explicitly verify it** before any side effect:

```php
use LiteUI\Security\Csrf;
if (!Csrf::verify(isset($_POST['_csrf']) ? $_POST['_csrf'] : null)) {
    http_response_code(403);
    exit('Invalid CSRF token');
}
```

Start the session/build the form before output. Sessions must be writable. Set Secure (HTTPS only), HttpOnly and appropriate SameSite session cookies in your application/server configuration. Tokens remain stable for the session; authentication session rotation is your responsibility.

HTML required/type attributes are browser hints, not server validation. Check input types before trimming; validate sizes and values before database writes. Use prepared statements. Escape handling is for HTML text/attributes only, never SQL, JavaScript or CSS contexts.

## Trust boundaries

Component text, table cells and attribute values are escaped. No raw HTML helper is provided. Component tag names and custom attribute names are developer-controlled configuration: **never derive them from untrusted input**. Arbitrary custom tags can include active elements; this API does not sandbox component authors. URL values are not authorization checks and can still point to external sites. Form actions should normally be trusted same-origin paths; do not send CSRF tokens to third-party endpoints.

## Production

Use a supported PHP runtime where possible. Expose only `public/` as the web root. Serve the CSS through a static alias or copy `assets/liteui.css` to `public/assets/`. The supplied router is for `php -S` development only. Configure your web server to route `/` to `public/index.php`; add your own application routing as needed. Disable displayed errors, log failures, enforce HTTPS and consider an appropriate Content Security Policy.

The example does not save submitted data and does not implement authentication. No production security audit has been performed.
