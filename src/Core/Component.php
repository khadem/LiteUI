<?php
namespace LiteUI\Core;

class Component
{
    protected $tag;
    protected $text;
    protected $attributes = array();
    protected $children = array();
    protected $void = false;

    public function __construct($tag = 'div', $text = '', array $attributes = array(), $void = false)
    {
        if (!preg_match('/^[a-z][a-z0-9-]*$/i', $tag)) { throw new \InvalidArgumentException('Invalid HTML tag'); }
        $this->tag = $tag;
        $this->text = $text;
        $this->void = $void;
        foreach ($attributes as $name => $value) { $this->attr($name, $value); }
    }
    public static function escape($value)
    {
        return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
    public static function safeUrl($url)
    {
        $url = (string) $url;
        if (preg_match('/[\x00-\x20\x7f]/', $url) || substr($url, 0, 2) === '//') {
            throw new \InvalidArgumentException('Unsafe URL');
        }
        if (preg_match('/^([a-z][a-z0-9+.-]*):/i', $url, $match) && !in_array(strtolower($match[1]), array('http', 'https', 'mailto', 'tel'), true)) {
            throw new \InvalidArgumentException('Unsupported URL scheme');
        }
        return $url;
    }
    public function attr($name, $value)
    {
        if (!preg_match('/^[a-z][a-z0-9_-]*$/i', $name) || preg_match('/^on/i', $name) || in_array(strtolower($name), array('srcdoc', 'style'), true)) {
            throw new \InvalidArgumentException('Unsafe attribute');
        }
        if (in_array(strtolower($name), array('href', 'src', 'action', 'formaction'), true)) { $value = self::safeUrl($value); }
        $this->attributes[$name] = $value;
        return $this;
    }
    public function class($classes)
    {
        $this->attributes['class'] = trim((isset($this->attributes['class']) ? $this->attributes['class'] : '') . ' ' . $classes);
        return $this;
    }
    public function text($text) { $this->text = $text; return $this; }
    public function add(Component $child) { $this->children[] = $child; return $child; }
    public function render()
    {
        $html = '<' . $this->tag;
        foreach ($this->attributes as $key => $value) {
            if ($value === false || $value === null) { continue; }
            $html .= ' ' . $key . ($value === true ? '' : '="' . self::escape($value) . '"');
        }
        $html .= '>';
        if ($this->void) { return $html; }
        $html .= self::escape($this->text);
        foreach ($this->children as $child) { $html .= $child->render(); }
        return $html . '</' . $this->tag . '>';
    }
}
