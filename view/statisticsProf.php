<?php
// Inclure le fichier de connexion à la base de données
require_once '../config/db.php';
session_start();

if(!isset($_SESSION['user_id'])){
    echo "vous devez etre connecter";
    exit;
}
$id_user = $_SESSION['user_id'];  // Récupérer l'ID de l'utilisateur (professeur)

// Requête pour compter le nombre d'étudiants inscrits aux cours de ce professeur
$stmt = $pdo->prepare('
    SELECT COUNT(DISTINCT i.id_user) AS total_etudiants 
    FROM inscription i
    JOIN cours c ON i.id_cours = c.id_cours
    WHERE c.id_user = ?
');
$stmt->execute([$id_user]);
$resultat = $stmt->fetch();
$totalEtudiants = $resultat['total_etudiants'];

// Requête pour compter le nombre de cours créés par le professeur
$stmt = $pdo->prepare('SELECT COUNT(*) AS total_cours FROM cours WHERE id_user = ?');
$stmt->execute([$id_user]);
$resultat = $stmt->fetch();
$totalCours = $resultat['total_cours'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Graphiques avec Chart.js</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <style>
        body {
            background-color: #f2f8ff;
        }
    </style>
</head>
<body>
<header class="mx-4">
    <div class="container flex justify-between items-center">
        <img src="../images/logo.png" alt="Logo" class="h-24 w-32">
        <div class="space-x-6 items-center mr-8">
            <a href="projets_view.php" class="text-center hover:text-gray-400" style="color:#24508c">Retour aux projets</a>
        </div>
    </div>               
</header>

<h2 class="text-center mt-[30px]">Graphiques : Distribution des Tâches, Projets et Utilisateurs</h2>
<section class="flex mt-[80px] justify-center">
    <canvas id="pieChart" style="width:100%;max-width:600px;">
    </canvas>
    <canvas id="barChart" style="width:100%;max-width:600px;"></canvas>
</section>

<script>
    // Récupérer les données PHP dans JavaScript
    var xValues = ['Etudiants', 'Cours'];
    var yValues = [<?php echo $totalEtudiants; ?>, <?php echo $totalCours; ?>];
    var barColors = ['blue', 'yellow'];

    // Affichage du graphique en camembert (pie chart)
    new Chart("pieChart", {
        type: "pie",
        data: {
            labels: xValues,
            datasets: [{
                backgroundColor: barColors,
                data: yValues
            }]
        },
        options: {
            title: {
                display: true,
                text: "Distribution des Tâches, Projets et Utilisateurs (Camembert)"
            }
        }
    });

    // Affichage du graphique en barres (bar chart)
    new Chart("barChart", {
        type: "bar",
        data: {
            labels: xValues,
            datasets: [{
                backgroundColor: barColors,
                data: yValues
            }]
        },
        options: {
            title: {
                display: true,
                text: "Distribution des Tâches, Projets et Utilisateurs (Barres)"
            },
            legend: { display: false },
            scales: {
                yAxes: [{
                    ticks: { beginAtZero: true }
                }]
            }
        }
    });
</script>

</body>
</html>
