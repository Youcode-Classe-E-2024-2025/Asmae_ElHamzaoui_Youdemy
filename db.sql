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

ALTER TABLE user
ADD COLUMN status ENUM('activer', 'désactiver') NOT NULL DEFAULT 'désactiver';


CREATE TABLE cours(
id_cours INT PRIMARY KEY AUTO_INCREMENT,
titre_cours VARCHAR(255) NOT NULL,
image_cours VARCHAR(255) NULL,
desc_cours VARCHAR(255) NOT NULL,
content_type ENUM('markdown', 'video') NOT NULL,
content_cours TEXT NOT NULL
);