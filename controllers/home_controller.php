<?php
// Contrôleur pour la page d'accueil

/**
 * Page d'accueil
 */
function home_index() {
    $data = [
        'title' => 'Accueil',
        'message' => 'Bienvenue sur mon livre d\'or !',
        
    ];
    
    load_view_with_layout('home/index', $data);
}

