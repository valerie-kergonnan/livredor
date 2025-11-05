<?php
// app/models/Messages_Model.php

class Messages_Model {
    protected $pdo;
    protected $table = 'messages';

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function all() {
        $stmt = $this->pdo->query("SELECT id, author, content, created_at FROM {$this->table} ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    public function find($id) {
        $stmt = $this->pdo->prepare("SELECT id, author, content, created_at FROM {$this->table} WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    /**
     * Retourne le message immédiatement plus récent que l'id donné (voisin "précédent"
     * dans l'ordre utilisé par la liste, c'est à dire created_at DESC).
     */
    public function previous($id) {
        // get the created_at for the current id first
        $tstmt = $this->pdo->prepare("SELECT created_at FROM {$this->table} WHERE id = :id LIMIT 1");
        $tstmt->execute([':id' => $id]);
        $row = $tstmt->fetch();
        if (!$row) return false;
        $created = $row['created_at'];

        $sql = "SELECT id, author, created_at FROM {$this->table} 
            WHERE (created_at > ? OR (created_at = ? AND id > ?)) 
            ORDER BY created_at ASC, id ASC LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$created, $created, $id]);
        return $stmt->fetch();
    }

    /**
     * Retourne le message immédiatement plus ancien que l'id donné (voisin "suivant").
     */
    public function next($id) {
        // get the created_at for the current id first
        $tstmt = $this->pdo->prepare("SELECT created_at FROM {$this->table} WHERE id = :id LIMIT 1");
        $tstmt->execute([':id' => $id]);
        $row = $tstmt->fetch();
        if (!$row) return false;
        $created = $row['created_at'];

        $sql = "SELECT id, author, created_at FROM {$this->table} 
            WHERE (created_at < ? OR (created_at = ? AND id < ?)) 
            ORDER BY created_at DESC, id DESC LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$created, $created, $id]);
        return $stmt->fetch();
    }

    public function create($author, $content) {
        $stmt = $this->pdo->prepare("INSERT INTO {$this->table} (author, content) VALUES (:author, :content)");
        return $stmt->execute([
            ':author' => $author,
            ':content' => $content
        ]);
    }
}
