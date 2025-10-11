<?php
// app/helpers.php

// render a view: path like 'guestbook/index'
function view($path, $data = []) {
    extract($data, EXTR_OVERWRITE);
    // capture le contenu de la vue
    ob_start();
    include VIEW_PATH . "/{$path}.php";
    $content = ob_get_clean();
    // include layout (qui affichera $content)
    include VIEW_PATH . "/layouts/layout.php";
}

// échappement XSS
function e($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

// Génère une URL absolue basée sur BASE_URL si disponible
function url($path = '') {
    // Utiliser BASE_URL si défini, sinon chemin relatif
    if (defined('BASE_URL') && !empty(BASE_URL)) {
        $base = rtrim(BASE_URL, '/');
        $path = ltrim($path, '/');
        return $base . ($path !== '' ? '/' . $path : '');
    }
    // fallback: retourner le chemin tel quel
    return '/' . ltrim($path, '/');
}

// redirection simple
function redirect($url) {
    header('Location: ' . $url);
    exit;
}

// flash messages
function set_flash($type, $msg) {
    $_SESSION['flash'][$type][] = $msg;
}
function get_flash_messages() {
    $f = $_SESSION['flash'] ?? [];
    unset($_SESSION['flash']);
    return $f;
}

// CSRF token utils
function csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        if (function_exists('random_bytes')) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        } else {
            $_SESSION['csrf_token'] = bin2hex(openssl_random_pseudo_bytes(32));
        }
    }
    return $_SESSION['csrf_token'];
}
function check_csrf($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}
