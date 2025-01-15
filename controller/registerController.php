<?php
// Inclusion des fichiers nécessaires
require_once '../config/db.php'; // Connexion à la base de données
require_once '../models/User.php'; // Classe User

// Vérifier si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les données envoyées par le formulaire
    $nom_user = $_POST['user_name'];
    $email_user = $_POST['user_email'];
    $password_user = $_POST['user_password'];
    $confirm_password_user = $_POST['user_confirm_password'];
    $role_user = $_POST['user_role'];

    // Validation côté serveur

    // Vérifier si tous les champs obligatoires sont remplis
    if (empty($nom_user) || empty($email_user) || empty($password_user) || empty($confirm_password_user) || empty($role_user)) {
        echo "Tous les champs sont requis.";
        exit;
    }

    // Vérification du format de l'email
    if (!filter_var($email_user, FILTER_VALIDATE_EMAIL)) {
        echo "L'adresse email est invalide.";
        exit;
    }

    // Vérifier si l'email est déjà utilisé
    $existingUser = User::getUserByEmail($db, $email_user);
    if ($existingUser) {
        echo "L'email est déjà utilisé. Veuillez en choisir un autre.";
        exit;
    }

    // Vérification des mots de passe (doivent correspondre)
    if ($password_user !== $confirm_password_user) {
        echo "Les mots de passe ne correspondent pas.";
        exit;
    }

    // Vérification de la longueur du mot de passe (min 6 caractères)
    if (strlen($password_user) < 6) {
        echo "Le mot de passe doit comporter au moins 6 caractères.";
        exit;
    }

    // Créer un objet User avec les données du formulaire
    $user = new User(null, $nom_user, $email_user, $password_user, $role_user);

    // Si l'utilisateur est un enseignant, le compte sera en attente de validation
    if ($role_user == 'Enseignant') {
        $user->setIsValid(0); // L'enseignant est en attente de validation
    } else {
        $user->setIsValid(1); // L'étudiant est validé directement
    }

    // Hacher le mot de passe
    $hashedPassword = $user->hashPassword();
    $user->setPasswordUser($hashedPassword); // Mettre à jour le mot de passe avec le mot de passe haché

    // Insérer l'utilisateur dans la base de données
    try {
        // Utilisation de la méthode `registerUser()` pour insérer les données
        $userId = $user->registerUser($db);
        
        if ($userId) {
            echo "Inscription réussie !";
            // Optionnel : Rediriger vers une page de confirmation, ou vers la page de connexion
            // header('Location: login.php');
        } else {
            echo "Une erreur est survenue lors de l'inscription.";
        }
    } catch (Exception $e) {
        // Gestion des erreurs
        echo "Erreur: " . $e->getMessage();
    }
} else {
    echo "Veuillez remplir le formulaire d'inscription.";
}
?>
