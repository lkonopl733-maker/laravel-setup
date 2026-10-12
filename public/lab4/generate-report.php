<?php
$cacheDir  = __DIR__ . '/cache';
$cacheFile = $cacheDir . '/report.html';
$ttl       = 600; // 10 хвилин

if (!is_dir($cacheDir)) {
    mkdir($cacheDir, 0777, true);
}

$isCached = false;
$source   = '';

if (file_exists($cacheFile) && (time() - filemtime($cacheFile) < $ttl)) {
    $htmlContent = file_get_contents($cacheFile);
    $isCached    = true;
    $source      = 'Файловий кеш (створено ' . date('Y-m-d H:i:s', filemtime($cacheFile)) . ')';
} else {
    sleep(3); // симуляція важкої генерації

    $names = ['Олександр', 'Марія', 'Іван', 'Софія', 'Андрій', 'Юлія', 'Максим', 'Вікторія'];

    ob_start();
    ?>
    <div style="font-family: Arial, sans-serif;">
        <h3>Згенерований фінансовий звіт</h3>
        <p style="color: green;">Створено на сервері: <?= date('Y-m-d H:i:s') ?></p>
        <table border="1" cellpadding="6" cellspacing="0"
               style="border-collapse: collapse; width: 100%;">
            <thead>
                <tr style="background: #f2f2f2;">
                    <th>ID</th><th>Ім'я</th><th>Сума (грн)</th><th>Дата</th>
                </tr>
            </thead>
            <tbody>
                <?php for ($i = 1; $i <= 1000; $i++): ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= $names[array_rand($names)] ?></td>
                        <td><?= number_format(rand(100, 50000) / 100, 2, '.', ' ') ?></td>
                        <td><?= date('Y-m-d', strtotime('-' . rand(0, 365) . ' days')) ?></td>
                    </tr>
                <?php endfor; ?>
            </tbody>
        </table>
    </div>
    <?php
    $htmlContent = ob_get_clean();
    file_put_contents($cacheFile, $htmlContent);
    $source = 'Нова генерація (sleep(3) + запис у файл)';
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Серверне файлове кешування</title>
</head>
<body style="padding: 20px; font-family: Arial;">
    <div style="padding: 12px; background: #e8f4f8; border: 1px solid #bbe1fa; margin-bottom: 15px;">
        <strong>Джерело:</strong> <?= htmlspecialchars($source) ?><br>
        <strong>Статус:</strong> <?= $isCached ? 'АКТИВНО (швидко)' : 'ПЕРЕЗГЕНЕРОВАНО' ?>
    </div>
    <?= $htmlContent ?>
</body>
</html>