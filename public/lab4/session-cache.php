<?php
session_start();

$ttl = 60; // 60 секунд

function generateData(): array {
    sleep(2);
    return [
        'usd'       => rand(38, 41),
        'eur'       => rand(41, 45),
        'timestamp' => date('H:i:s')
    ];
}

// Очистка кешу
if (isset($_GET['clear'])) {
    unset($_SESSION['cached_data'], $_SESSION['cached_time']);
    header('Location: session-cache.php');
    exit;
}

if (isset($_SESSION['cached_data'], $_SESSION['cached_time'])) {
    $age = time() - $_SESSION['cached_time'];
    if ($age < $ttl) {
        $data   = $_SESSION['cached_data'];
        $source = "Кеш сесії (вік: {$age} сек)";
    } else {
        $data   = generateData();
        $_SESSION['cached_data'] = $data;
        $_SESSION['cached_time'] = time();
        $source = 'Оновлено кеш (TTL минув)';
    }
} else {
    $data   = generateData();
    $_SESSION['cached_data'] = $data;
    $_SESSION['cached_time'] = time();
    $source = 'Створено новий кеш у сесії';
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Кешування через PHP-сесію</title>
</head>
<body style="font-family: Arial; padding: 20px;">
    <h2>Курси валют (сесійне кешування)</h2>
    <p><strong>Дані:</strong> <?= htmlspecialchars(json_encode($data, JSON_UNESCAPED_UNICODE)) ?></p>
    <p><strong>Джерело:</strong> <?= htmlspecialchars($source) ?></p>
    <p>
        <a href="session-cache.php">Оновити</a> |
        <a href="session-cache.php?clear=1">Очистити кеш</a> |
        <a href="index.html">Головна</a>
    </p>
</body>
</html>