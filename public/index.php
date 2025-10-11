<?php
/**
 * Point d'entrée principal de l'application
 * Utilise le bootstrap du projet qui initialise l'autoload, les helpers et
 * lance le routeur personnalisé.
 */

require_once __DIR__ . '/../bootstrap.php';

// Lancer le routeur
route();