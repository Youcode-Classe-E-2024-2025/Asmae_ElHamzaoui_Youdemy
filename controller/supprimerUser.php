<?php 

// require_once '../config/db.php';
// require_once '../model/user.php';


// Vérifier si un ID d'utilisateur est passé dans la requête
// if (isset($_GET['id_user']) && !empty($_GET['id_user'])) {
//     $id_user = $_GET['id_user'];

//     // Créer une instance de l'utilisateur avec l'ID spécifique
//     $user = new User($id_user);

//     // Appeler la méthode pour supprimer l'utilisateur
//     $result = $user->deleteUser($db);

//     // Rediriger ou afficher un message en fonction du résultat
//     if ($result === "Utilisateur supprimé avec succès.") {
//         // Rediriger vers la liste des utilisateurs ou afficher un message de succès
//         header('Location: users_list.php');  // Changez ceci en fonction de l'endroit où vous voulez rediriger
//         exit();
//     } else {
//         // Afficher un message d'erreur
//         echo "Erreur : " . $result;
//     }
// } else {
//     echo "ID utilisateur manquant.";
// }
?>
