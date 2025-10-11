<?php
// Système de routing simple

/**
 * Parse l'URL et retourne le contrôleur, l'action et les paramètres
 */
function parse_request_url() {
    $url = $_GET['url'] ?? '';
    $url = rtrim($url, '/');
    $url = filter_var($url, FILTER_SANITIZE_URL);
    if (empty($url)) {
        return ['controller' => 'home', 'action' => 'index', 'params' => []];
    }
    
    $url_parts = explode('/', $url);
    
    $controller = $url_parts[0] ?? 'home';
    $action = $url_parts[1] ?? 'index';
    // Supporter les segments de type key=value (ex: /controller/page=2)
    if (isset($url_parts[1]) && strpos($url_parts[1], '=') !== false) {
        // construire la query string et rediriger vers l'URL propre
        // Ex: /livre-d-or/page=2/other -> /livre-d-or?page=2&other
        $query = $url_parts[1];
        // ajouter d'autres segments en tant que paramètres (optionnel)
        $extra = array_slice($url_parts, 2);
        if (!empty($extra)) {
            // concatener segments supplémentaires en tant que paramX=val si présents
            // ici on les ajoute comme path[]=segment1&path[]=segment2
            foreach ($extra as $seg) {
                // échapper
                $query .= '&path[]=' . rawurlencode($seg);
            }
        }

        // Eviter les boucles : si la requête a déjà une query string, ne pas rediriger
        if (empty($_SERVER['QUERY_STRING'])) {
            $base = url($controller);
            $location = rtrim($base, '/') . '?' . $query;
            header('Location: ' . $location, true, 301);
            exit;
        }

        // Si on arrive ici, on a déjà une query string ; on injecte simplement
        parse_str($url_parts[1], $kv);
        foreach ($kv as $k => $v) {
            if (!isset($_GET[$k])) {
                $_GET[$k] = $v;
            }
        }
        $action = 'index';
        $params = array_slice($url_parts, 2);
        return [
            'controller' => $controller,
            'action' => $action,
            'params' => $params
        ];
    }
    $params = array_slice($url_parts, 2);
    
    return [
        'controller' => $controller,
        'action' => $action,
        'params' => $params
    ];
}

/**
 * Fonction principale de routage - point d'entrée
 */
function route() {
    dispatch();
}

/**
 * Charge et exécute le contrôleur approprié
 */
function dispatch() {
    $route = parse_request_url();
    
    $controller_name = $route['controller'];
    $action_name = $route['action'];
    $params = $route['params'];
    
    // Nom du fichier contrôleur (on conserve les tirets pour le nom de fichier)
    $controller_file = CONTROLLER_PATH . '/' . $controller_name . '_controller.php';
    
    // Vérifier si le contrôleur existe
    if (!file_exists($controller_file)) {
        // Contrôleur par défaut pour les erreurs 404
        load_404();
        return;
    }
    
    // Charger le contrôleur
    require_once $controller_file;
    
    // Nom de la fonction d'action
    // Remplacer les tirets par des underscores pour obtenir un nom de fonction PHP valide
    $function_controller = str_replace('-', '_', $controller_name);
    $function_action = str_replace('-', '_', $action_name);
    $action_function = $function_controller . '_' . $function_action;
    
    // Vérifier si l'action existe
    if (!function_exists($action_function)) {
        load_404();
        return;
    }
    
    // Exécuter l'action avec les paramètres
    call_user_func_array($action_function, $params);
}

/**
 * Charge la page 404
 */
function load_404() {
    http_response_code(404);
    require_once VIEW_PATH . '/errors/404.php';
}

 