<?php
header('Content-Type: text/css; charset=UTF-8');

// Кеш на 1 день
$seconds = 86400;
header('Cache-Control: public, max-age=' . $seconds);
header('Expires: ' . gmdate('D, d M Y H:i:s', time() + $seconds) . ' GMT');

$primaryColor   = '#3498db';
$backgroundColor = '#ecf0f1';
?>
/* Згенеровано: <?= date('Y-m-d H:i:s') ?> */
body {
    background-color: <?= $backgroundColor ?>;
    font-family: Arial, sans-serif;
    color: #333;
    margin: 20px;
}
.card {
    background: #fff;
    padding: 25px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    border-left: 5px solid <?= $primaryColor ?>;
}