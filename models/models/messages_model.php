<?php
// app/models/Messages_Model.php

class Messages_Model {
    protected $pdo;
    protected $table = 'messages'; // adapte si besoin

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function all() {
        $stmt = $this->pdo->query("SELECT id, author, content, created_at FROM {$this->table} ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    public function create($author, $content) {
        $stmt = $this->pdo->prepare("INSERT INTO {$this->table} (author, content) VALUES (:author, :content)");
        return $stmt->execute([
            ':author' => $author,
            ':content' => $content
        ]);
    }
}
