-- Ajouter la colonne created_at à la table users si elle n'existe pas
ALTER TABLE users 
ADD COLUMN created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP;
