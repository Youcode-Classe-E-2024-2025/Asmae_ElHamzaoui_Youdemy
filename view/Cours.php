<?php
// Inclure le fichier de connexion à la base de données et les classes de cours
require_once '../config/db.php';
require_once '../model/cours.php'; // Assure-toi d'inclure ce fichier

// Récupérer tous les cours depuis la base de données
$stmt = $pdo->query("SELECT * FROM cours");
$coursData = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

        canvas {
            display: block;
            height: 500px;
            width: 100%;
            background-color: #dadfdc;
        }

        /* Style pour la barre de navigation */
        .navbar {
            position: sticky;
            top: 0;
            z-index: 100;
            width: 100%;
            background-color: #24508c;
            padding: 10px 0;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            font-size: 18px;
        }

        .navbar a:hover {
            background-color: #1a3b63;
        }

        /* Ajout d'un peu de marge pour que le contenu ne soit pas caché sous la navbar */
        .content {
            padding-top: 80px; /* Ajustez selon la hauteur de la navbar fixe */
        }

        /* Style du header fixe */
        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background-color: white;
            z-index: 10; /* Pour être sûr qu'il reste au-dessus du contenu */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        /* Style du logo et du menu */
        .logo {
            width: 40px;
            margin-right: 10px;
        }

        nav {
            display: flex;
            gap: 20px;
        }

        .nav-item {
            font-weight: bold;
            color: #000;
        }

        .nav-item:hover {
            color: #1c4933;
        }

        .auth-buttons a {
            background-color: #1c4933;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .auth-buttons a:hover {
            background-color: #2c6e4e;
        }

        /* Espacement pour que le contenu ne soit pas caché sous le header */
        .main-content {
            padding-top: 80px; /* Laisser de l'espace sous le header */
        }
    </style>
</head>

<body>
    <!-- Barre de navigation -->
    <header>
        <div class="flex items-center justify-between py-4 px-6 bg-white">
            <img src="../assets/images/logo.png" alt="Logo" class="logo">
            <nav class="space-x-8 md:flex">
                <a href="home.php" class="nav-item">Home</a>
                <a href="AboutUs.php" class="nav-item">About us</a>
                <a href="Cours.php" class="nav-item">Cours</a>
            </nav>
            <div class="auth-buttons space-x-4">
                <a href="direction.php">Sign Up</a>
                <a href="login.php">Log In</a>
            </div>
        </div>
    </header>

    <!-- Affichage des cours -->
    <div class="main-content container mx-auto px-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            <?php foreach ($coursData as $course): ?>
                <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                    <a href="taches_view.php?id_cours=<?php echo $course['id_cours']; ?>">
                        <img class="rounded-t-lg" src="<?php echo htmlspecialchars($course['image_cours']); ?>" alt="" />
                    </a>
                    <div class="p-5">
                        <a href="#">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white" style="color:#24508c"><?php echo htmlspecialchars($course['titre_cours']); ?></h5>
                        </a>
                        <p class="mb-3 font-bold text-gray-700 dark:text-gray-400"><?php echo htmlspecialchars($course['desc_cours']); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

</body>

</html>
