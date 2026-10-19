<?php
require dirname(__DIR__) . '/autoload.php';
use LiteUI\UI;
use LiteUI\Core\Component;

UI::register('badge', function ($props) {
    return new Component('span', $props['text'], array('class' => 'lu-alert'));
});
$page = UI::page('Custom component');
$page->add(UI::component('badge', array('text' => 'Hello LiteUI')));
echo $page->render();
