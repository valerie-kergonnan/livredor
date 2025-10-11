<?php
// Contrôleur pour la page d'accueil

/**
 * Page d'accueil
 */
function home_index() {
    $data = [
        'title' => 'Accueil',
        'message' => 'Bienvenue sur votre application PHP MVC !',
        'features' => [
            'Architecture MVC claire',
            'Système de routing simple',
            'Templating HTML/CSS',
            'Gestion de base de données',
            'Sécurité intégrée'
        ]
    ];
    
    load_view_with_layout('home/index', $data);
}

