<?php
// Inclure le fichier de connexion à la base de données et les classes de cours
require_once '../config/db.php';
require_once '../model/cours.php'; // Assure-toi d'inclure ce fichier

// Paramètres pour la pagination
$limit = 12; // Nombre de cours par page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Gestion de la recherche
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

// Construire la requête avec la recherche
$query = "SELECT * FROM cours WHERE titre_cours LIKE :search LIMIT :limit OFFSET :offset";
$stmt = $pdo->prepare($query);
$stmt->bindValue(':search', '%'.$searchTerm.'%', PDO::PARAM_STR);
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();

$coursData = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calculer le nombre total de pages
$totalQuery = "SELECT COUNT(*) FROM cours WHERE titre_cours LIKE :search";
$stmtTotal = $pdo->prepare($totalQuery);
$stmtTotal->bindValue(':search', '%'.$searchTerm.'%', PDO::PARAM_STR);
$stmtTotal->execute();
$totalCours = $stmtTotal->fetchColumn();
$totalPages = ceil($totalCours / $limit);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #dadfdc;
            overflow-x: hidden;
            overflow-y: auto;
        }
    </style>
</head>
<body>
    
  <h1 class="text-center text-2xl font-bold mt-32" style="color:#1c4933">Votre compte est en cours de vérification</h1>
  <h1 class="text-center text-2xl font-bold mt-6" style="color:#1c4933">Merci d'avoir attendu</h1>



  

</body>

</html>
