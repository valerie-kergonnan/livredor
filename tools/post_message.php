<?php
require __DIR__ . '/../bootstrap.php';
$author = 'AutomatedTest';
$content = 'Message de test posté par l\'assistant le ' . date('Y-m-d H:i:s');
$ok = db_execute('INSERT INTO messages (author, content, created_at) VALUES (?, ?, NOW())', [$author, $content]);
if ($ok) {
    echo "INSERT_OK\n";
    echo "LAST_ID=" . db_last_insert_id() . "\n";
} else {
    echo "INSERT_FAILED\n";
}
