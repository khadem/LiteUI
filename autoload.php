<?php
spl_autoload_register(function ($class) {
    $prefix = 'LiteUI\\';
    if (strpos($class, $prefix) !== 0) { return; }
    $file = __DIR__ . '/src/' . str_replace('\\', '/', substr($class, strlen($prefix))) . '.php';
    if (is_file($file)) { require $file; }
});
