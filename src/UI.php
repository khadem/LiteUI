<?php
namespace LiteUI;
use LiteUI\Core\Page;
use LiteUI\Core\Component;

final class UI
{
    private static $factories = array();
    public static function page($title = 'LiteUI') { return new Page($title); }
    public static function register($name, callable $factory) { self::$factories[$name] = $factory; }
    public static function component($name, array $props = array())
    {
        if (!isset(self::$factories[$name])) { throw new \InvalidArgumentException('Unknown component: ' . $name); }
        $component = call_user_func(self::$factories[$name], $props);
        if (!$component instanceof Component) { throw new \UnexpectedValueException('Factory must return a Component'); }
        return $component;
    }
}
