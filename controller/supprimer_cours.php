<?php
// Inclure le fichier de connexion à la base de données et les classes de cours
require_once '../config/db.php';
require_once '../model/cours.php'; // Assurez-vous d'inclure ce fichier

// Vérifier si l'ID du cours a été passé via POST
if (isset($_POST['cours_id'])) {
    $cours_id = $_POST['cours_id'];

    $cours = new CoursMarkdown('', '', '', '', '', $cours_id); // Utilisez les bonnes valeurs ici
    $cours->supprimerCours($pdo);

    // Après la suppression, rediriger vers la page des cours
    header("Location: ../view/teacherInterface.php"); 
    exit();
} else {
    // Si l'ID du cours n'est pas passé, rediriger vers la page des cours
    header("Location: ../view/teacherInterface.php");
    exit();
}
?>
