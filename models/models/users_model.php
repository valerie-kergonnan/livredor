<?php

// recupere tous les utilisateurs
function user_all_get(){
    return db_select("SELECT * FROM users ORDER BY first_name, last_name");
}

// recuperer  un utilisateur par son id 
function get_user_by_id($id){
    return db_select_one("SELECT * FROM users where id = ?", [$id]);
}

// creer un  nouvel utilisateur 
function create_user($first_name, $last_name, $email, $password){
    // vérifier si l'email existe déjà
    $existingUser = db_select_one("SELECT id FROM users WHERE email = ?", [$email]);
    if ($existingUser) {
        return false;
    }

    // hasher le mot de passe
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // inserer un nouvel utilisateur
    $query = "INSERT INTO users(first_name, last_name, email, password, created_at)\nVALUES (?, ?, ?, ?, NOW())";

    if (db_execute($query, [$first_name, $last_name, $email, $hashed_password])) {
        return db_last_insert_id();
    }

    return false;
}

// authentification de  l'utilisateur
function authenticate_user($email, $password){
    $user = 
    db_select_one("SELECT * FROM users WHERE email = ?", [$email]);
    if ($user && isset($user['password']) && password_verify($password, $user['password'])) {
        return $user;
    }
    return false;
}