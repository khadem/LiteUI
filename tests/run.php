<?php
require dirname(__DIR__) . '/autoload.php';
use LiteUI\UI;
use LiteUI\Core\Component;
use LiteUI\Security\Csrf;

$count = 0;
function check($condition, $message) {
    global $count;
    if (!$condition) { throw new RuntimeException($message); }
    $count++;
}
function rejects($callback) {
    try { $callback(); } catch (InvalidArgumentException $e) { return true; }
    return false;
}
$token = Csrf::token();
check(Csrf::verify($token), 'Valid CSRF');
check(!Csrf::verify('invalid'), 'Invalid CSRF');
check(!Csrf::verify(array()), 'Non-string CSRF');
$page = UI::page('<Title>')->rtl()->lang('fa');
$page->column(function ($c) {
    $c->card(function ($card) { $card->label('<script>alert(1)</script>'); });
    $c->form('/save', function ($f) { $f->input('email', 'Email')->type('email')->required()->value('" autofocus'); $f->button('Save'); });
    $c->table(array('x' => '<Header>'), array(array('x' => '<Cell>')));
});
$html = $page->render();
check(strpos($html, 'dir="rtl"') !== false, 'RTL');
check(strpos($html, '&lt;Title&gt;') !== false, 'Title escaping');
check(strpos($html, '<script>') === false, 'Text escaping');
check(strpos($html, '&lt;Header&gt;') !== false, 'Header escaping');
check(strpos($html, '&lt;Cell&gt;') !== false, 'Cell escaping');
check(strpos($html, 'name="_csrf"') !== false, 'Token field');
check(strpos($html, 'value="&quot; autofocus"') !== false, 'Attribute escaping');
check(rejects(function () { new Component('a', '', array('href' => 'javascript:alert(1)')); }), 'URL scheme');
check(rejects(function () { new Component('a', '', array('href' => "java\nscript:alert(1)")); }), 'Control characters');
check(rejects(function () { new Component('a', '', array('href' => '//example.com')); }), 'Protocol-relative URL');
check(rejects(function () { (new Component())->attr('onclick', 'alert(1)'); }), 'Event attributes');
check(rejects(function () { (new Component())->attr('bad name', 'x'); }), 'Attribute names');
check(rejects(function () { new Component('div><script'); }), 'Tag names');
check(rejects(function () { UI::page()->heading('bad', 9); }), 'Heading bounds');
check(rejects(function () { UI::page()->form('/', null, 'delete'); }), 'Form methods');
$get = UI::page()->form('/search', null, 'get')->render();
check(strpos($get, '_csrf') === false, 'GET has no token');
UI::register('badge', function ($props) { return new Component('span', $props['text']); });
check(UI::component('badge', array('text' => '<ok>'))->render() === '<span>&lt;ok&gt;</span>', 'Factory');
check((new Component('input', '', array('disabled' => false), true))->render() === '<input>', 'Boolean false');
echo 'PASS: ' . $count . " checks\n";
