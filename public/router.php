<?php
// Development server only. Never expose the project root in production.
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
if ($path === '/assets/liteui.css') {
    header('Content-Type: text/css; charset=utf-8');
    readfile(dirname(__DIR__) . '/assets/liteui.css');
    return true;
}
if ($path !== '/') { http_response_code(404); echo 'Not found'; return true; }
require __DIR__ . '/index.php';
