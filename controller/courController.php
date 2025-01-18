<?php 
// Inclure le modèle des cours
require_once '../model/cours.php';

// Vérifier si la requête est une soumission de formulaire POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $titre_cours = $_POST['title'];
    $image_cours = $_POST['image_cours'] ?? null; // Image est optionnelle
    $desc_cours = $_POST['description'];
    $content_type = '';
    $content_cours = '';

    // Vérifier quel type de contenu a été soumis (Markdown ou Vidéo)
    if (isset($_POST['markdownContent']) && !empty($_POST['markdownContent'])) {
        // Si le contenu est du markdown
        $content_type = 'markdown';
        $content_cours = $_POST['markdownContent'];
    } elseif (isset($_FILES['videoFile']) && $_FILES['videoFile']['error'] === UPLOAD_ERR_OK) {
        // Si une vidéo est uploadée

        // Vérifier l'extension du fichier vidéo (optionnel mais recommandé)
        $allowed_types = ['mp4', 'avi', 'mov', 'mkv'];
        $video_file_type = pathinfo($_FILES['videoFile']['name'], PATHINFO_EXTENSION);

        if (!in_array(strtolower($video_file_type), $allowed_types)) {
            die("Type de fichier vidéo non autorisé. Les types autorisés sont : mp4, avi, mov, mkv.");
        }

        // Définir le répertoire de destination pour les vidéos
        $upload_dir = '../uploads/videos/';
        
        // Vérifier si le répertoire de destination existe, sinon créer le répertoire
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true); // Créer le répertoire avec les permissions appropriées
        }

        // Déplacer le fichier vidéo vers un répertoire de stockage
        $video_name = basename($_FILES['videoFile']['name']);
        $upload_path = $upload_dir . $video_name;

        // Vérifier si le fichier a été correctement déplacé
        if (move_uploaded_file($_FILES['videoFile']['tmp_name'], $upload_path)) {
            $content_cours = $upload_path; // Stocker le chemin du fichier vidéo
        } else {
            die("Erreur lors de l'upload de la vidéo.");
        }

        // Définir le type de contenu pour vidéo
        $content_type = 'video';
    } else {
        die("Aucun contenu valide sélectionné.");
    }

    // Créer une instance de la classe correspondante (Markdown ou Vidéo)
    if ($content_type === 'markdown') {
        $cours = new CoursMarkdown($titre_cours, $desc_cours, $content_type, $content_cours, $image_cours);
    } elseif ($content_type === 'video') {
        $cours = new CoursVideo($titre_cours, $desc_cours, $content_type, $content_cours, $image_cours);
    } else {
        die("Type de contenu invalide.");
    }

    // Ajouter le cours à la base de données
    try {
        $cours->ajouterCours($pdo);
        // Rediriger ou afficher un message de succès
        header("Location: ../view/teacherInterface.php"); 
    } catch (Exception $e) {
        die("Erreur lors de l'ajout du cours à la base de données : " . $e->getMessage());
    }

    exit();
} else {
    // Si la requête n'est pas une soumission de formulaire POST, rediriger vers la page d'accueil ou une autre page
    echo "soumission INCorrecte";    
    exit();
}
?>
