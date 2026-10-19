<?php
namespace LiteUI\Core;

class Page extends Container
{
    private $title;
    private $language = 'en';
    private $direction = 'ltr';
    private $assetPath = '/assets';
    public function __construct($title) { parent::__construct('main', '', array('class' => 'lu-page')); $this->title = $title; }
    public function lang($language) { $this->language = $language; return $this; }
    public function rtl($enabled = true) { $this->direction = $enabled ? 'rtl' : 'ltr'; return $this; }
    public function assets($path) { $this->assetPath = rtrim(self::safeUrl($path), '/'); return $this; }
    public function render()
    {
        return '<!doctype html><html lang="' . self::escape($this->language) . '" dir="' . $this->direction . '"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>' . self::escape($this->title) . '</title><link rel="stylesheet" href="' . self::escape($this->assetPath . '/liteui.css') . '"></head><body>' . parent::render() . '</body></html>';
    }
}
