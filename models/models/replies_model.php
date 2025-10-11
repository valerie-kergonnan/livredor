<?php
// app/models/Replies_Model.php

class Replies_Model {
    protected $pdo;
    protected $table = 'replies';

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function findByMessageId($message_id) {
        $stmt = $this->pdo->prepare("SELECT id, message_id, author, content, created_at FROM {$this->table} WHERE message_id = :mid ORDER BY created_at ASC");
        $stmt->execute([':mid' => $message_id]);
        return $stmt->fetchAll();
    }

    public function create($message_id, $author, $content) {
        $stmt = $this->pdo->prepare("INSERT INTO {$this->table} (message_id, author, content) VALUES (:mid, :author, :content)");
        return $stmt->execute([
            ':mid' => $message_id,
            ':author' => $author,
            ':content' => $content
        ]);
    }
}
