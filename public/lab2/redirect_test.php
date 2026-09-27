<?php
// Отримуємо метод поточного запиту
$request_method = $_SERVER['REQUEST_METHOD'] ?? '';
// Якщо метод не POST, перенаправ. на гол. сторінку
if ($request_method !== 'POST') {

    header("Location: index.php");
    exit;
}
// Якщо запит POST
echo "Ви надіслали POST-запит!";