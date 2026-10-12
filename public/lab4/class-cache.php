<?php
class DataCache {
    private static array $memoryCache = [];

    public static function get(string $key, callable $generator, int $ttl = 30): array {
        $now = time();

        if (isset(self::$memoryCache[$key]) &&
            ($now - self::$memoryCache[$key]['time'] < $ttl)) {
            return [
                'data'   => self::$memoryCache[$key]['data'],
                'source' => 'Статична властивість класу (RAM, в межах запиту)'
            ];
        }

        $data = $generator();
        self::$memoryCache[$key] = [
            'data' => $data,
            'time' => $now
        ];

        return [
            'data'   => $data,
            'source' => 'Свіжа генерація (метод класу)'
        ];
    }
}

// Демонстрація: два виклики в одному запиті
$result1 = DataCache::get('heavy', function () {
    sleep(2);
    return 'Результат важких обчислень: ' . rand(1000, 9999);
}, 30);

$result2 = DataCache::get('heavy', function () {
    sleep(2);
    return 'Результат важких обчислень: ' . rand(1000, 9999);
}, 30);
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Кешування через статичну властивість</title>
</head>
<body style="font-family: Arial; padding: 20px;">
    <h2>Кешування через статичну властивість класу</h2>

    <p><strong>Перший виклик:</strong> <?= htmlspecialchars($result1['data']) ?></p>
    <p><strong>Джерело 1:</strong> <?= $result1['source'] ?></p>

    <p><strong>Другий виклик (той самий ключ):</strong> <?= htmlspecialchars($result2['data']) ?></p>
    <p><strong>Джерело 2:</strong> <?= $result2['source'] ?></p>

    <p style="color: #666; font-size: 0.9em;">
        Примітка: статична властивість живе тільки протягом одного HTTP-запиту.
        При перезавантаженні сторінки кеш скидається (це нормальна поведінка PHP).
    </p>

    <p><a href="class-cache.php">Оновити сторінку</a> | <a href="index.html">Головна</a></p>
</body>
</html>