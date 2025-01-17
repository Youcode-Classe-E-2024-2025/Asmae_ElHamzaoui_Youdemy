<?php
// Inclusion des fichiers nécessaires
require_once '../config/db.php';  // Connexion à la base de données
require_once '../models/User.php';  // Classe User

// Démarrer une session
session_start();

// Vérifier si l'utilisateur est déjà connecté, dans ce cas rediriger vers la page personnelle
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');  // Remplacez par la page de votre tableau de bord
    exit;
}

// Vérifier si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les données envoyées par le formulaire
    $email_user = $_POST['user_email'];
    $password_user = $_POST['user_password'];

    // Vérifier si les champs sont remplis
    if (empty($email_user) || empty($password_user)) {
        echo "L'email et le mot de passe sont requis.";
        exit;
    }

    // Chercher l'utilisateur dans la base de données
    $user = User::getUserByEmail($db, $email_user);

    // Si l'utilisateur existe
    if ($user) {
        // Vérifier si le mot de passe est correct
        if (password_verify($password_user, $user['user_password'])) {
            // Démarrer la session
            $_SESSION['user_id'] = $user['id_user']; // ID utilisateur stocké en session
            $_SESSION['user_name'] = $user['user_name']; // Nom de l'utilisateur
            $_SESSION['user_role'] = $user['user_role']; // Rôle de l'utilisateur
            
            // Rediriger l'utilisateur vers la page de son tableau de bord (personnel)
            header('Location: dashboard.php');
            exit;
        } else {
            echo "Le mot de passe est incorrect.";
        }
    } else {
        echo "L'email n'est pas enregistré.";
    }
}
?>