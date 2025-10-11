<?php
require __DIR__ . '/../bootstrap.php';
$rows = db_select('SELECT id, author, content, created_at FROM messages ORDER BY created_at DESC LIMIT 20');
echo json_encode($rows, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . PHP_EOL;
