CREATE DATABASE coursbase;

use coursbase;

CREATE TABLE user (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    user_name VARCHAR(255) NOT NULL,
    user_email VARCHAR(255) UNIQUE NOT NULL,
    user_password VARCHAR(255) NOT NULL,
    user_role ENUM('Etudiant', 'Enseignant', 'Admin') NOT NULL,
    is_valid TINYINT(1) NOT NULL DEFAULT 0
);
