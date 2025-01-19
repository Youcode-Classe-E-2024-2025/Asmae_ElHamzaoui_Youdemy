<?php
// Inclusion des fichiers nécessaires
require_once '../config/db.php'; // Connexion à la base de données
require_once '../model/user.php'; // Classe User

// Démarrer la session
session_start();

// Vérifier si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les données envoyées par le formulaire
    $email_user = $_POST['email'];
    $password_user = $_POST['password'];

    // Validation côté serveur
    if (empty($email_user) || empty($password_user)) {
        echo "L'email et le mot de passe sont requis.";
        exit;
    }

    // Vérification du format de l'email
    if (!filter_var($email_user, FILTER_VALIDATE_EMAIL)) {
        echo "L'adresse email est invalide.";
        exit;
    }

    // Récupérer l'utilisateur par email
    try {
        $existingUser = User::getUserByEmail($pdo, $email_user);

        // Si l'utilisateur n'existe pas
        if (!$existingUser) {
            echo "Aucun utilisateur trouvé avec cet email.";
            exit;
        }

        // Vérification du mot de passe
        if (!password_verify($password_user, $existingUser['user_password'])) {
            echo "Mot de passe incorrect.";
            exit;
        }

        // Vérifier si le compte est validé
        if ($existingUser['is_valid'] == 0) {
            echo "Votre compte est en attente de validation.";
            exit;
        }

        // Vérifier si le compte est désactivé
        if ($existingUser['status'] == 'désactiver') {
            echo "Votre compte a été désactivé.";
            exit;
        }

        // Stocker les informations de l'utilisateur dans la session
        $_SESSION['user_id'] = $existingUser['user_id'];
        $_SESSION['user_name'] = $existingUser['user_name'];
        $_SESSION['user_email'] = $existingUser['user_email'];
        $_SESSION['user_role'] = $existingUser['user_role'];

        // Redirection en fonction du rôle
        if ($existingUser['user_role'] == 'Enseignant') {
            // Rediriger vers la page Enseignant
            header('Location: ../view/teacherInterface.php');
        } else {
            // Rediriger vers la page Étudiant
            header('Location: ../view/studentInterface.php');
        }
        exit;

    } catch (Exception $e) {
        // Gestion des erreurs
        echo "Erreur: " . $e->getMessage();
    }
} else {
    echo "Veuillez remplir le formulaire de connexion.";
}
?>
