<?php
session_start();

//Автоматичне завершення сесії через 5 хвилин
$timeout = 300;

if (isset($_SESSION['last_activity']) &&
    time() - $_SESSION['last_activity'] > $timeout) {

    session_unset();
    session_destroy();
    session_start();

    $session_expired_message = "Сесія завершилася через неактивність більше 5 хвилин.";
}
// Зчитування даних з cookie та сесії і оновлення часу активності
$_SESSION['last_activity'] = time();

$savedName = $_COOKIE['user_name'] ?? null;

$past_purchases = isset($_COOKIE['past_purchases'])
    ? json_decode($_COOKIE['past_purchases'], true)
    : [];

$login_error = $_SESSION['login_error'] ?? null;
unset($_SESSION['login_error']);
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Лабораторна робота 2 </title>
    <style>
        body { font-family: Arial; margin: 20px; }
        .block { border: 1px solid #ccc; padding: 15px; margin-bottom: 20px; }
        .alert { color: red; font-weight: bold; }
    </style>
</head>
<body>


<?php if (isset($session_expired_message)): ?>
    <p class="alert"><?= htmlspecialchars($session_expired_message) ?></p>
<?php endif; ?>


<!-- COOKIE -->
<div class="block">
    <h2>1. Робота з $_COOKIE</h2>

    <?php if ($savedName): ?>

        <h3>Ласкаво просимо, <?= htmlspecialchars($savedName) ?>!</h3>

        <form action="process.php" method="POST">
            <input type="hidden" name="action" value="delete_cookie">
            <button type="submit">Видалити cookie</button>
        </form>

    <?php else: ?>

        <form action="process.php" method="POST">
            <label>Введіть ваше ім'я:</label>
            <input type="text" name="username" required>
            <button type="submit" name="action" value="save_cookie">
                Зберегти
            </button>
        </form>

    <?php endif; ?>
</div>


<!-- SESSION -->
<div class="block">
    <h2>2. Робота з $_SESSION</h2>

    <?php if ($login_error): ?>
        <p class="alert"><?= htmlspecialchars($login_error) ?></p>
    <?php endif; ?>

    <?php if (isset($_SESSION['logged_user'])): ?>

        <h3>
            Вітаємо, <?= htmlspecialchars($_SESSION['logged_user']) ?>!
            Ви авторизовані.
        </h3>

        <form action="process.php" method="POST">
            <input type="hidden" name="action" value="logout">
            <button type="submit">Вихід</button>
        </form>

    <?php else: ?>

        <form action="process.php" method="POST">
            <input type="hidden" name="action" value="login">

            <p>
                Логін:
                <input type="text" name="login" required>
            </p>

            <p>
                Пароль:
                <input type="password" name="password" required>
            </p>

            <button type="submit">Увійти</button>
        </form>

        <p>Тестовий логін: <b>admin</b>, пароль: <b>12345</b></p>

    <?php endif; ?>
</div>


<!--SERVER -->
<div class="block">
    <h2>3. Робота з $_SERVER</h2>

    <ul>
        <li>IP-адреса: <?= htmlspecialchars($_SERVER['REMOTE_ADDR'] ?? '') ?></li>
        <li>Браузер: <?= htmlspecialchars($_SERVER['HTTP_USER_AGENT'] ?? '') ?></li>
        <li>Назва скрипта: <?= htmlspecialchars($_SERVER['PHP_SELF'] ?? '') ?></li>
        <li>Метод запиту: <?= htmlspecialchars($_SERVER['REQUEST_METHOD'] ?? '') ?></li>
        <li>Шлях до файлу: <?= htmlspecialchars($_SERVER['SCRIPT_FILENAME'] ?? '') ?></li>
    </ul>

    <a href="redirect_test.php">Перевірити редирект</a>
</div>


<!--корзина -->
<div class="block">
    <h2>4. Корзина покупок</h2>

    <form action="process.php" method="POST">
        <input type="hidden" name="action" value="add_to_cart">

        <label>Додати товар:</label>
        <input type="text" name="item_name" placeholder="Наприклад: Ноутбук" required>

        <button type="submit">Додати</button>
    </form>

    <h3>Поточна корзина ($_SESSION):</h3>

    <?php if (!empty($_SESSION['cart'])): ?>

        <ul>
            <?php foreach ($_SESSION['cart'] as $item): ?>
                <li><?= htmlspecialchars($item) ?></li>
            <?php endforeach; ?>
        </ul>

        <form action="process.php" method="POST">
            <input type="hidden" name="action" value="complete_purchase">
            <button type="submit">Завершити покупку</button>
        </form>

    <?php else: ?>
        <p>Корзина порожня.</p>
    <?php endif; ?>

    <h3>Попередні покупки ($_COOKIE):</h3>

    <?php if (!empty($past_purchases)): ?>

        <ul>
            <?php foreach ($past_purchases as $item): ?>
                <li><?= htmlspecialchars($item) ?></li>
            <?php endforeach; ?>
        </ul>

    <?php else: ?>
        <p>Попередніх покупок немає.</p>
    <?php endif; ?>
</div>

</body>
</html>