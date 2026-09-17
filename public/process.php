<?php
// Перевіряємо, чи дані були відправлені методом POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Отримуємо значення з глобального масиву $_POST 
    $firstName = isset($_POST['first_name']) ? trim($_POST['first_name']) : '';
    $lastName = isset($_POST['last_name']) ? trim($_POST['last_name']) : '';

    $errors = []; // Масив для зберігання помилок

    // Перевірка  на пусті значення
    if (empty($firstName)) {
        $errors[] = "Поле 'Ім'я' не може бути порожнім.";
    }

    if (empty($lastName)) {
        $errors[] = "Поле 'Прізвище' не може бути порожнім.";
    }

    // Перевірка на тип даних (чи містять рядки лише літери)
    if (!empty($firstName) && !preg_match("/^[a-zA-Zа-яА-ЯєЄіІїЇґҐ' ]+$/u", $firstName)) {
        $errors[] = "Ім'я повинно містити лише літери.";
    }

    if (!empty($lastName) && !preg_match("/^[a-zA-Zа-яА-ЯєЄіІїЇґҐ' ]+$/u", $lastName)) {
        $errors[] = "Прізвище повинно містити лише літери.";
    }

    // Виведення результату або помилок
    if (empty($errors)) {
        $safeFirstName = htmlspecialchars($firstName);
        $safeLastName = htmlspecialchars($lastName);

        // Виведення привітання користувачу
        echo "<h2>Вітаємо, " . $safeFirstName . " " . $safeLastName . "!</h2>";
        echo "<p>Дані успішно отримані та оброблені.</p>";
    } else {
        // Якщо є помилки — виводимо їх
        echo "<h3 style='color: red;'>Виникли помилки при заповненні форми:</h3>";
        echo "<ul>";
        foreach ($errors as $error) {
            echo "<li>" . htmlspecialchars($error) . "</li>";
        }
        echo "</ul>";
        echo "<a href='index.html'>Повернутися до форми</a>";
    }

} else {
    // Якщо файл відкрили напряму, а не через відправку форми
    echo "Будь ласка, відправте форму з сторінки <a href='index.html'>index.html</a>.";
}
?>