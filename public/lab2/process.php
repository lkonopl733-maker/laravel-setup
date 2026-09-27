<?php
session_start();

$action = $_POST['action'] ?? '';

switch ($action) {
//Збереження імені користувача в cookie на 7 днів
    case 'save_cookie':
        setcookie('user_name', trim($_POST['username']), time() + 7 * 24 * 60 * 60, '/');
        break;
//Видалення cookie з ім'ям користувача
    case 'delete_cookie':
        setcookie('user_name', '', time() - 3600, '/');
        break;
//авторизація
    case 'login':
        if ($_POST['login'] === 'admin' && $_POST['password'] === '12345') {
            $_SESSION['logged_user'] = $_POST['login'];
        } else {
            $_SESSION['login_error'] = 'Неправильний логін або пароль.';
        }
        break;
//очищення сесії
    case 'logout':
        unset($_SESSION['logged_user']);
        break;
//Додавання товару в корзину
    case 'add_to_cart':
        $_SESSION['cart'][] = trim($_POST['item_name']);
        break;
//перенос товару з сесії в cookie "попередні покупки"
    case 'complete_purchase':
        if (!empty($_SESSION['cart'])) {
            $past = json_decode($_COOKIE['past_purchases'] ?? '[]', true);

            foreach ($_SESSION['cart'] as $item) {
                $past[] = $item;
            }
//// Збережено попередні покупки в cookie на 30 днів
            setcookie(
                'past_purchases',
                json_encode($past, JSON_UNESCAPED_UNICODE),
                time() + 30 * 24 * 60 * 60,
                '/'
            );

            unset($_SESSION['cart']);
        }
        break;
}

header('Location: index.php');
exit;