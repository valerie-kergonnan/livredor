<?php
// app/config.php
// Modifie ces paramètres selon ton environnement
$db_host = 'localhost';
$db_name = 'livredor';
$db_user = 'root';
$db_pass = '';
$dsn = "mysql:host=$db_host;dbname=$db_name;charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $db_user, $db_pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    // En dev : afficher l'erreur. En production, logguer et afficher message générique.
    die("Erreur connexion BD : " . $e->getMessage());
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
