<?php
/**
 * Fichier d'amorçage pour l'initialisation de l'application
 */

// Démarrer la session si elle n'est pas déjà démarrée
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Définir le chemin racine du projet seulement s'il n'est pas déjà défini
if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', __DIR__);
}

// Charger la configuration
require_once ROOT_PATH . '/config/database.php';

// Charger les fichiers core
require_once CORE_PATH . '/database.php';
require_once CORE_PATH . '/router.php';
require_once CORE_PATH . '/view.php';

// Charger les fichiers utilitaires
require_once INCLUDE_PATH . '/helpers.php';

// Charger tous les modèles (supporte sous-dossiers)
$modelFiles = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(MODEL_PATH));
foreach ($modelFiles as $file) {
    if ($file->isFile() && strtolower($file->getExtension()) === 'php') {
        require_once $file->getPathname();
    }
}

// Charger tous les contrôleurs
foreach (glob(CONTROLLER_PATH . '/*.php') as $controller_file) {
    require_once $controller_file;
}

// Configuration pour le développement
error_reporting(E_ALL);
ini_set('display_errors', 1);