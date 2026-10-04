<?php
$uploadDir = 'uploads/';

// Створєння папки uploads, якщо вона не існує
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['upload_file'])) {
    $file = $_FILES['upload_file'];

    // Перевірка помилок завантаження
    if ($file['error'] !== UPLOAD_ERR_OK) {
        die("Помилка при завантаженні файлу. Код помилки: " . $file['error']);
    }

    // Перевірка через is_uploaded_file() 
    if (!is_uploaded_file($file['tmp_name'])) {
        die("Помилка: Файл не був завантажений через HTTP POST.");
    }

    // Перевірка розміру (максимум 2 МБ = 2 * 1024 * 1024 байтів) 
    $maxSize = 2 * 1024 * 1024;
    if ($file['size'] > $maxSize) {
        die("Помилка: Розмір файлу перевищує допустимий ліміт у 2 МБ.");
    }

    // Перевірка типу файлу (png, jpg, jpeg)
    $allowedExtensions = ['png', 'jpg', 'jpeg'];
    $fileInfo = pathinfo($file['name']);
    $fileExtension = strtolower($fileInfo['extension'] ?? '');

    if (!in_array($fileExtension, $allowedExtensions)) {
        die("Помилка: Дозволено завантажувати лише зображення формату PNG, JPG або JPEG.");
    }

    $originalName = $fileInfo['filename'];
    $fileName = $file['name'];
    $targetPath = $uploadDir . $fileName;
    $renamedNotice = "";

    // Перевірка наявності файлу та створення унікальної назви 
    if (file_exists($targetPath)) {
        $uniqueSuffix = '_' . date('Ymd_His');
        $fileName = $originalName . $uniqueSuffix . '.' . $fileExtension;
        $targetPath = $uploadDir . $fileName;
        $renamedNotice = "<p style='color: orange;'>Файл з таким ім'ям вже існував. Ім'я змінено на: <strong>" . htmlspecialchars($fileName) . "</strong></p>";
    }

    // Переміщення файлу
    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        $fileSizeKB = round($file['size'] / 1024, 2);

        // Виведення інформації про файл та посилання на завантаження
        echo "<h2>Файл завантажений</h2>";
        echo $renamedNotice;
        echo "<ul>";
        echo "<li><strong>Ім'я файлу:</strong> " . htmlspecialchars($fileName) . "</li>";
        echo "<li><strong>Тип файлу:</strong> " . htmlspecialchars($file['type']) . "</li>";
        echo "<li><strong>Розмір:</strong> " . $fileSizeKB . " KB</li>";
        echo "</ul>";

        // Посилання для завантаження файлу назад
        echo "<p><a href='" . htmlspecialchars($targetPath) . "' download>Завантажити файл назад</a></p>";
        echo "<p><a href='index.html'>Повернутися на головну</a> | <a href='list.php'>Переглянути всі файли</a></p>";
    } else {
        echo "Виникла помилка при збереженні файлу на сервері.";
    }
} else {
    echo "Будь ласка, відправте форму.";
}
?>