<?php
namespace LiteUI\Forms;
use LiteUI\Core\Component;

class Input extends Component
{
    private $control;
    public function __construct($name, $label)
    {
        parent::__construct('label', '', array('class' => 'lu-field'));
        $this->add(new Component('span', $label));
        $this->control = $this->add(new Component('input', '', array('name' => $name, 'type' => 'text'), true));
    }
    public function type($type)
    {
        if (!in_array($type, array('text', 'email', 'password', 'number', 'date', 'tel', 'url', 'search'), true)) { throw new \InvalidArgumentException('Unsupported input type'); }
        $this->control->attr('type', $type); return $this;
    }
    public function value($value) { $this->control->attr('value', $value); return $this; }
    public function required($required = true) { $this->control->attr('required', $required); return $this; }
    public function placeholder($text) { $this->control->attr('placeholder', $text); return $this; }
    public function controlAttr($name, $value) { $this->control->attr($name, $value); return $this; }
}
