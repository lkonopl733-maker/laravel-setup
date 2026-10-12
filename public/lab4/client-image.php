<?php
header('Content-Type: image/svg+xml; charset=UTF-8');

// Кеш на 2 дні
$seconds = 172800;
header('Cache-Control: public, max-age=' . $seconds);
header('Expires: ' . gmdate('D, d M Y H:i:s', time() + $seconds) . ' GMT');
header('ETag: "cache-image-v1"');

echo '<?xml version="1.0" encoding="UTF-8"?>
<svg xmlns="http://www.w3.org/2000/svg" width="160" height="50" viewBox="0 0 160 50">
  <rect width="100%" height="100%" fill="#3498db" rx="8"/>
  <text x="50%" y="50%" fill="#ffffff" font-family="Arial" font-size="14"
        font-weight="bold" dominant-baseline="middle" text-anchor="middle">
    Cached Asset 2
  </text>
</svg>';