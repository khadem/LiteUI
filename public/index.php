<?php
require dirname(__DIR__) . '/autoload.php';
use LiteUI\UI;
use LiteUI\Security\Csrf;

// Initialize sessions before any response output. Use HTTPS and secure cookies in production.
Csrf::token();
$name = ''; $email = ''; $message = ''; $kind = 'info';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!Csrf::verify(isset($_POST['_csrf']) ? $_POST['_csrf'] : null)) {
        http_response_code(403); $message = 'درخواست نامعتبر است. صفحه را دوباره باز کنید.'; $kind = 'error';
    } else {
        $name = isset($_POST['name']) && is_string($_POST['name']) ? trim($_POST['name']) : '';
        $email = isset($_POST['email']) && is_string($_POST['email']) ? trim($_POST['email']) : '';
        if ($name === '' || strlen($name) > 200 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            http_response_code(422); $message = 'نام و ایمیل معتبر وارد کنید.'; $kind = 'error';
        } else { $message = 'اطلاعات معتبر است؛ این نمونه چیزی ذخیره نمی‌کند.'; $kind = 'success'; }
    }
}
$page = UI::page('LiteUI Demo')->lang('fa')->rtl();
$page->column(function ($column) use ($name, $email, $message, $kind) {
    $column->heading('LiteUI — رابط ساده با PHP');
    $column->label('سبک، ماژولار و بدون وابستگی جاوااسکریپت');
    if ($message !== '') { $column->alert($message, $kind); }
    $column->card(function ($card) use ($name, $email) {
        $card->heading('فرم نمونه', 2);
        $card->form('/', function ($form) use ($name, $email) {
            $form->input('name', 'نام')->value($name)->required()->controlAttr('maxlength', 200);
            $form->input('email', 'ایمیل')->type('email')->value($email)->required();
            $form->button('بررسی اطلاعات');
        });
    });
    $column->table(array('name' => 'کامپوننت', 'status' => 'وضعیت'), array(
        array('name' => 'Form / Input', 'status' => 'آماده'),
        array('name' => 'Card / Row / Column', 'status' => 'آماده'),
        array('name' => 'Table / Alert', 'status' => 'آماده')
    ));
});
header('Content-Type: text/html; charset=utf-8');
echo $page->render();
