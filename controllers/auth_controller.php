<?php
// controllers/auth_controller.php

class AuthController
{
    protected $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Affiche le formulaire de connexion
     */
    public function login()
    {
        // Si déjà connecté, rediriger vers l'accueil
        if (is_logged_in()) {
            redirect('/');
            return;
        }

        $flash = get_flash_messages();
        view('auth/login', ['flash' => $flash]);
    }

    /**
     * Traite la soumission du formulaire de connexion
     */
    public function doLogin()
    {
        // Vérification CSRF
        if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
            set_flash_message('error', 'Token de sécurité invalide.');
            redirect('/auth/login');
            return;
        }

        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        // Validation
        if (empty($email) || empty($password)) {
            set_flash_message('error', 'Email et mot de passe sont requis.');
            redirect('/auth/login');
            return;
        }

        // Authentification
        $user = authenticate_user($email, $password);

        if ($user) {
            // Créer la session utilisateur
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];

            set_flash_message('success', 'Bienvenue ' . htmlspecialchars($user['first_name']) . ' !');

            // Rediriger vers la page d'origine ou l'accueil
            $redirect = $_SESSION['redirect_after_login'] ?? '/';
            unset($_SESSION['redirect_after_login']);
            redirect($redirect);
        } else {
            set_flash_message('error', 'Email ou mot de passe incorrect.');
            redirect('/auth/login');
        }
    }

    /**
     * Affiche le formulaire d'inscription
     */
    public function register()
    {
        // Si déjà connecté, rediriger vers l'accueil
        if (is_logged_in()) {
            redirect('/');
            return;
        }

        $flash = get_flash_messages();
        view('auth/register', ['flash' => $flash]);
    }

    /**
     * Traite la soumission du formulaire d'inscription
     */
    public function doRegister()
    {
        // Vérification CSRF
        if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
            set_flash_message('error', 'Token de sécurité invalide.');
            redirect('/auth/register');
            return;
        }

        $first_name = trim($_POST['first_name'] ?? '');
        $last_name = trim($_POST['last_name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $password_confirm = $_POST['password_confirm'] ?? '';

        // Validation
        $errors = [];

        if (empty($first_name)) {
            $errors[] = 'Le prénom est requis.';
        }
        if (empty($last_name)) {
            $errors[] = 'Le nom est requis.';
        }
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Email valide requis.';
        }
        if (empty($password) || strlen($password) < 6) {
            $errors[] = 'Le mot de passe doit contenir au moins 6 caractères.';
        }
        if ($password !== $password_confirm) {
            $errors[] = 'Les mots de passe ne correspondent pas.';
        }

        if (!empty($errors)) {
            foreach ($errors as $error) {
                set_flash_message('error', $error);
            }
            redirect('/auth/register');
            return;
        }

        // Créer l'utilisateur
        $userId = create_user($first_name, $last_name, $email, $password);

        if ($userId) {
            set_flash_message('success', 'Inscription réussie ! Vous pouvez maintenant vous connecter.');
            redirect('/auth/login');
        } else {
            set_flash_message('error', 'Cet email est déjà utilisé ou une erreur est survenue.');
            redirect('/auth/register');
        }
    }

    /**
     * Déconnexion
     */
    public function logout()
    {
        // Détruire la session utilisateur
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);

        set_flash_message('success', 'Vous avez été déconnecté avec succès.');
        redirect('/');
    }

    /**
     * Affiche le profil utilisateur
     */
    public function profile()
    {
        // Vérifier que l'utilisateur est connecté
        if (!is_logged_in()) {
            $_SESSION['redirect_after_login'] = '/auth/profile';
            set_flash_message('error', 'Vous devez être connecté pour accéder à cette page.');
            redirect('/auth/login');
            return;
        }

        $userId = $_SESSION['user_id'];
        $user = get_user_by_id($userId);

        if (!$user) {
            set_flash_message('error', 'Utilisateur introuvable.');
            redirect('/');
            return;
        }

        $flash = get_flash_messages();
        view('auth/profile', ['user' => $user, 'flash' => $flash]);
    }
}

// Fonctions wrapper pour le routeur
function auth_login()
{
    $pdo = db_connect();
    $controller = new AuthController($pdo);
    $controller->login();
}

function auth_do_login()
{
    $pdo = db_connect();
    $controller = new AuthController($pdo);
    $controller->doLogin();
}

function auth_register()
{
    $pdo = db_connect();
    $controller = new AuthController($pdo);
    $controller->register();
}

function auth_do_register()
{
    $pdo = db_connect();
    $controller = new AuthController($pdo);
    $controller->doRegister();
}

function auth_logout()
{
    $pdo = db_connect();
    $controller = new AuthController($pdo);
    $controller->logout();
}

function auth_profile()
{
    $pdo = db_connect();
    $controller = new AuthController($pdo);
    $controller->profile();
}
