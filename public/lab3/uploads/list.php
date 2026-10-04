<?php
$uploadDir = 'uploads/';
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Список завантажених файлів</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        ul { line-height: 1.8; }
        a { color: #0066cc; text-decoration: none; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>

    <h2>Список файлів у директорії uploads</h2>

    <?php
    if (is_dir($uploadDir)) {
        // Отримання списку елементів директорії без '.' та '..'
        $files = array_diff(scandir($uploadDir), ['.', '..']);

        if (!empty($files)) {
            echo "<ul>";
            foreach ($files as $file) {
                $filePath = $uploadDir . $file;
                // виведення тільки файлу
                if (is_file($filePath)) {
                    $fileSizeKB = round(filesize($filePath) / 1024, 2);
                    echo "<li>";
                    echo "<strong>" . htmlspecialchars($file) . "</strong> (" . $fileSizeKB . " KB) — ";
                    echo "<a href='" . htmlspecialchars($filePath) . "' download>Завантажити</a>";
                    echo "</li>";
                }
            }
            echo "</ul>";
        } else {
            echo "<p>Директорія порожня. Файли ще не завантажувалися.</p>";
        }
    } else {
        echo "<p>Директорія <code>uploads/</code> ще не створена.</p>";
    }
    ?>

    <br>
    <a href="index.html">Повернутися на головну</a>

</body>
</html>