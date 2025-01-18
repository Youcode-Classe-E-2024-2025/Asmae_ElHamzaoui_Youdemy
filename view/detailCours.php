<?php
// Inclure le fichier de connexion à la base de données et les classes de cours
require 'vendor/erusev/parsedown/Parsedown.php';

require_once '../config/db.php';
require_once '../model/cours.php';

// Vérifier si un ID de cours est passé dans l'URL
if (isset($_GET['id_cour'])) {
    $cours_id = $_GET['id_cour'];

    // Récupérer les détails du cours depuis la base de données
    $stmt = $pdo->prepare('SELECT * FROM cours WHERE id_cours = ?');
    $stmt->execute([$cours_id]);
    $course = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérifier si le cours existe
    if (!$course) {
        die('Cours non trouvé');
    }

    // Déterminer le type de contenu du cours
    $content_type = $course['content_type'];

    // Si le contenu est de type Markdown, le convertir en HTML
    if ($content_type === 'markdown') {
        $parsedown = new Parsedown();
        // Convertir le contenu markdown en HTML
        $course['content_cours'] = $parsedown->text($course['content_cours']);
    }
} else {
    die('ID de cours non spécifié');
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détail du Cours</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold text-center mb-6">Détail du Cours: <?php echo htmlspecialchars($course['titre_cours']); ?></h1>
        
        <!-- Image du cours -->
        <div class="mb-6">
            <?php if ($course['image_cours']): ?>
                <img src="<?php echo htmlspecialchars($course['image_cours']); ?>" alt="Image du cours" class="w-full max-w-3xl mx-auto rounded-lg shadow-md">
            <?php else: ?>
                <p class="text-gray-600 text-center">Aucune image disponible pour ce cours.</p>
            <?php endif; ?>
        </div>
        
        <!-- Description du cours -->
        <div class="mb-6">
            <h2 class="text-2xl font-semibold mb-2">Description</h2>
            <p class="text-lg text-gray-700"><?php echo nl2br(htmlspecialchars($course['desc_cours'])); ?></p>
        </div>

        <!-- Contenu du cours en fonction du type -->
        <div class="mb-6">
            <?php if ($content_type === 'markdown'): ?>
                <h2 class="text-2xl font-semibold mb-2">Contenu du cours (Markdown)</h2>
                <div class="prose max-w-none">
                    <!-- Affichage du contenu Markdown converti en HTML -->
                    <?php echo $course['content_cours']; ?>
                </div>
            <?php elseif ($content_type === 'video'): ?>
                <h2 class="text-2xl font-semibold mb-2">Vidéo du cours</h2>
                <div class="flex justify-center">
                    <video controls class="w-full max-w-3xl rounded-lg shadow-md">
                        <source src="<?php echo htmlspecialchars($course['content_cours']); ?>" type="video/mp4">
                        Votre navigateur ne prend pas en charge la vidéo.
                    </video>
                </div>
            <?php endif; ?>
        </div>

        <!-- Retour à la liste des cours -->
        <div class="flex justify-center">
            <a href="liste_cours.php" class="text-white bg-blue-600 px-6 py-2 rounded hover:bg-blue-700">
                Retour à la liste des cours
            </a>
        </div>
    </div>
</body>
</html>
