<?php
namespace LiteUI\Security;

final class Csrf
{
    private static function start()
    {
        if (session_status() !== PHP_SESSION_ACTIVE && !session_start()) { throw new \RuntimeException('Cannot start session'); }
    }
    public static function token()
    {
        self::start();
        if (empty($_SESSION['_liteui_csrf'])) { $_SESSION['_liteui_csrf'] = bin2hex(random_bytes(32)); }
        return $_SESSION['_liteui_csrf'];
    }
    public static function verify($token)
    {
        self::start();
        return is_string($token) && isset($_SESSION['_liteui_csrf']) && hash_equals($_SESSION['_liteui_csrf'], $token);
    }
}
