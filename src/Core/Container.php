<?php
namespace LiteUI\Core;

use LiteUI\Forms\Input;
use LiteUI\Forms\Form;
use LiteUI\Data\Table;

class Container extends Component
{
    protected function group($class, $callback)
    {
        $child = $this->add(new self('div', '', array('class' => $class)));
        if ($callback !== null) { call_user_func($callback, $child); }
        return $child;
    }
    public function column($callback = null) { return $this->group('lu-column', $callback); }
    public function row($callback = null) { return $this->group('lu-row', $callback); }
    public function card($callback = null) { return $this->group('lu-card', $callback); }
    public function label($text) { return $this->add(new Component('p', $text)); }
    public function heading($text, $level = 1)
    {
        if ($level < 1 || $level > 6) { throw new \InvalidArgumentException('Heading level must be 1..6'); }
        return $this->add(new Component('h' . (int) $level, $text));
    }
    public function link($text, $url) { return $this->add(new Component('a', $text, array('href' => $url))); }
    public function input($name, $label) { return $this->add(new Input($name, $label)); }
    public function button($text) { return $this->add(new Component('button', $text, array('type' => 'submit', 'class' => 'lu-button'))); }
    public function form($action, $callback = null, $method = 'post')
    {
        $form = $this->add(new Form($action, $method));
        if ($callback !== null) { call_user_func($callback, $form); }
        return $form;
    }
    public function table(array $columns, array $rows) { return $this->add(new Table($columns, $rows)); }
    public function alert($text, $kind = 'info')
    {
        if (!in_array($kind, array('info', 'success', 'error'), true)) { throw new \InvalidArgumentException('Invalid alert kind'); }
        return $this->add(new Component('div', $text, array('class' => 'lu-alert lu-' . $kind, 'role' => 'status')));
    }
}
