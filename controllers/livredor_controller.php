<?php
// app/controllers/LivredorController.php

class LivredorController {
    protected $pdo;
    protected $model;
    // replies feature removed

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
        $this->model = new Messages_Model($pdo);
        // replies feature removed
    }

    // replies feature was removed

    // affiche la page du livre d'or
    public function index() {
        $messages = $this->model->all();
    $flash = get_flash_messages();
    view('livredor/index', ['messages' => $messages, 'flash' => $flash]);
    }

    // afficher un message individuel
    public function show($id = null) {
        if ($id === null) {
            load_404();
            return;
        }
        $m = $this->model->find((int) $id);
        if (!$m) {
            load_404();
            return;
        }
        
        $prev = $this->model->previous((int) $id);
        $next = $this->model->next((int) $id);
        // Si requête AJAX (param ajax=1), retourner la vue partielle sans layout
        if (!empty($_GET['ajax'])) {
            // expose $message for the partial
            $message = $m;
            $prevMessage = $prev;
            $nextMessage = $next;
            include VIEW_PATH . '/livredor/show_partial.php';
            return;
        }

        view('livredor/show', ['message' => $m, 'prev' => $prev, 'next' => $next]);
    }

    // traite la soumission du formulaire
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/livredor');
        }

        $author = trim($_POST['author'] ?? '');
        $content = trim($_POST['content'] ?? '');
        $token = $_POST['csrf_token'] ?? '';

        // CSRF
        if (!check_csrf($token)) {
            set_flash('error', 'Jeton CSRF invalide.');
            redirect('/livredor');
        }

        // validation simple
        if ($author === '' || $content === '') {
            set_flash('error', 'Tous les champs sont requis.');
            redirect('/livredor');
        }
        if (mb_strlen($author) > 100) {
            set_flash('error', 'Nom trop long (max 100 char).');
            redirect('/livredor');
        }
        if (mb_strlen($content) > 2000) {
            set_flash('error', 'Message trop long (max 2000 char).');
            redirect('/livredor');
        }

        // insertion
        $ok = $this->model->create($author, $content);
        if ($ok) {
            set_flash('success', 'Merci — votre message a été ajouté.');
        } else {
            set_flash('error', 'Impossible d\'ajouter le message. Réessayez.');
        }

        redirect('/livredor');
    }
}

// Procedural wrappers for compatibility with the procedural router
if (!function_exists('livredor_index')) {
    function livredor_index(...$params) {
        // Use the project's db connection helper
        $pdo = function_exists('db_connect') ? db_connect() : null;
        $controller = new LivredorController($pdo);
        return call_user_func_array([$controller, 'index'], $params);
    }
}

if (!function_exists('livredor_store')) {
    function livredor_store(...$params) {
        $pdo = function_exists('db_connect') ? db_connect() : null;
        $controller = new LivredorController($pdo);
        return call_user_func_array([$controller, 'store'], $params);
    }
}

if (!function_exists('livredor_show')) {
    function livredor_show(...$params) {
        $pdo = function_exists('db_connect') ? db_connect() : null;
        $controller = new LivredorController($pdo);
        return call_user_func_array([$controller, 'show'], $params);
    }
}

// no additional routes
