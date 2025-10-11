-- database/create_replies_table.sql
-- Migration: create replies table linked to messages

CREATE TABLE IF NOT EXISTS replies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    message_id INT NOT NULL,
    author VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (message_id) REFERENCES messages(id) ON DELETE CASCADE
);
