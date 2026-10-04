<?php
$logFile = 'log.txt';

// Перевірка отримання даних з POST-запиту та збереження в log.txt
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['user_text'])) {
    $text = trim($_POST['user_text']);
    // змінна $entry з датою та текстом
    $entry = "[" . date('Y-m-d H:i:s') . "] " . $text . PHP_EOL;

    // Відкриття файл у режимі 'a' (дописування в кінець)
    $f = fopen($logFile, 'a');
    if ($f) {
        fwrite($f, $entry);
        fclose($f);
    }

    // Перенаправлення, щоб уникнути повторного відправлення форми при оновленні сторінки
    header("Location: text.php");
    exit();
}

//читання з файлу
$fileContent = '';
if (file_exists($logFile) && filesize($logFile) > 0) {
    $f = fopen($logFile, 'r');
    if ($f) {
        $fileContent = fread($f, filesize($logFile));
        fclose($f);
    }
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Вміст log.txt</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        pre { background: #f4f4f4; padding: 15px; border: 1px solid #ddd; border-radius: 4px; }
    </style>
</head>
<body>

    <h2>Вміст файлу log.txt</h2>

    <?php if (!empty($fileContent)): ?>
        <pre><?php echo htmlspecialchars($fileContent); ?></pre>
    <?php else: ?>
        <p>Файл <code>log.txt</code> порожній або ще не створений.</p>
    <?php endif; ?>

    <p><a href="index.html">Повернутися на головну</a></p>

</body>
</html>