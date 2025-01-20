<!-- 
<?php
require_once '../config/db.php'; // Assurez-vous que la connexion à la base de données est correcte
require_once('../controllers/tacheController.php');
require_once('../controllers/projetController.php');
require_once('../models/userModel.php');

$tache = new TacheController($pdo);  
$tasks = $tache->afficherTache();
$projet = new ProjetController($pdo);  
$projects = $projet->afficherProjets();


function afficherUsers() {
    global $pdo;
    $query = "SELECT * FROM Utilisateur";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    // Récupérer toutes les lignes sous forme de tableau
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$users = afficherUsers();

$users=afficherUsers();

$totalEtudiants = count($tasks); 
$totalCours = count($projects);

// Générer les variables JavaScript avec les données récupérées
?> -->

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
            background-color:#f2f8ff;
        }
    </style>
</head>
<body>
<header class="mx-4">
    <div class="container flex justify-between items-center">
        <!-- Logo avec taille augmentée -->
        <img src="../images/logo.png" alt="Logo" class="h-24 w-32"> <!-- Ajout de la classe "logo" pour appliquer la transformation -->
        <div class="space-x-6 items-center mr-8"> <!-- Espacement égal entre les éléments --> 
              <a href="projets_view.php"  class="text-center hover:text-gray-400" style="color:#24508c">retour aux projets</a>
        </div>
    </div>               
</header>
    <h2 class="text-center mt-[30px]">Graphiques : Distribution des Tâches, Projets et Utilisateurs</h2>

    <section class="flex mt-[80px] justify-center">
        <canvas id="pieChart" style="width:100%;max-width:600px;"></canvas>
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
