<?php
// Démarrer la session
session_start();

// Détruire toutes les variables de session
session_unset();

// Détruire la session
session_destroy();

// Rediriger l'utilisateur vers la page d'accueil ou la page de connexion
header('Location: login.php'); // Remplacez 'index.php' par l'URL de votre page d'accueil ou de connexion
exit();
?>