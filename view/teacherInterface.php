<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des cours</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
    <style>
        .hidden { display: none; }
    </style>
</head>
<body>
    <h1>Ajouter un cours</h1>
    <form id="courseForm" action="../controller/courController.php" method="POST" enctype="multipart/form-data">
        <label for="title">Titre :</label><br>
        <input type="text" id="title" name="title" required><br><br>

        <!-- Image du Cours (optionnelle) -->
        <label for="image_cours">Image (optionnelle):</label>
        <input type="text" name="image_cours" id="image_cours"><br>

        <label for="description">Description :</label><br>
        <textarea id="description" name="description" required></textarea><br><br>

        <label for="content">Contenu :</label><br>
        <div>
            <button type="button" id="markdownButton">Saisir du Markdown</button>
            <button type="button" id="videoButton">Importer une vidéo</button>
        </div><br>

        <div id="markdownContainer" class="hidden">
            <textarea id="markdownContent" name="markdownContent"></textarea>
        </div>

        <div id="videoContainer" class="hidden">
            <input type="file" id="videoFile" name="videoFile" accept="video/*">
        </div><br>

        <button type="submit">Ajouter le cours</button>
    </form>

    <h2>Liste des cours</h2>
    <div id="courseList"></div>

    <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
    <script>
        const markdownButton = document.getElementById('markdownButton');
        const videoButton = document.getElementById('videoButton');
        const markdownContainer = document.getElementById('markdownContainer');
        const videoContainer = document.getElementById('videoContainer');
        const courseList = document.getElementById('courseList');

        // Initialiser SimpleMDE pour l'éditeur Markdown
        const simplemde = new SimpleMDE({ element: document.getElementById("markdownContent") });

        // Afficher la section Markdown et masquer la vidéo
        markdownButton.addEventListener('click', () => {
            markdownContainer.classList.remove('hidden');
            videoContainer.classList.add('hidden');
        });

        // Afficher la section Vidéo et masquer Markdown
        videoButton.addEventListener('click', () => {
            videoContainer.classList.remove('hidden');
            markdownContainer.classList.add('hidden');
        });

        // Empêcher l'envoi du formulaire si ni markdown ni vidéo n'est sélectionné
        document.getElementById("courseForm").addEventListener("submit", function(event) {
            // Si aucun contenu n'est sélectionné, avertir l'utilisateur
            if (!markdownContainer.classList.contains('hidden') && !document.getElementById('markdownContent').value) {
                alert("Veuillez entrer du contenu Markdown ou importer une vidéo.");
                event.preventDefault(); // Empêcher l'envoi du formulaire
            }
            if (!videoContainer.classList.contains('hidden') && !document.getElementById('videoFile').files.length) {
                alert("Veuillez importer une vidéo.");
                event.preventDefault(); // Empêcher l'envoi du formulaire
            }
        });
    </script>
</body>
</html>
