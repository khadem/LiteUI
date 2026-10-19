<?php
namespace LiteUI\Forms;
use LiteUI\Core\Container;
use LiteUI\Core\Component;
use LiteUI\Security\Csrf;

class Form extends Container
{
    public function __construct($action, $method = 'post')
    {
        $method = strtolower($method);
        if (!in_array($method, array('get', 'post'), true)) { throw new \InvalidArgumentException('Use GET or POST'); }
        parent::__construct('form', '', array('action' => $action, 'method' => $method, 'class' => 'lu-column'));
        if ($method === 'post') { $this->add(new Component('input', '', array('type' => 'hidden', 'name' => '_csrf', 'value' => Csrf::token()), true)); }
    }
}
