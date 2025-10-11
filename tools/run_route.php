<?php
require __DIR__ . '/../bootstrap.php';

// Usage: php run_route.php [route]
// Exemple: php run_route.php home   -> simule la page d'accueil (pas de css)
//          php run_route.php livredor -> simule /livredor (doit charger le css)
$routeArg = $argv[1] ?? '';
if ($routeArg !== '' && $routeArg !== 'home') {
	$_GET['url'] = $routeArg;
} else {
	// unset pour simuler la page d'accueil
	unset($_GET['url']);
}

ob_start();
route();
$content = ob_get_clean();
echo $content;
