<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mes cours</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
             /* Le modal sera placé au-dessus du contenu avec un fond semi-transparent */
             #modal, #modal-assigner {
                 display: none; /* Initialement caché */
                 position: fixed; /* Pour qu'il soit fixé en haut de la page */
                 top: 0;
                 left: 0;
                 right: 0;
                 bottom: 0;
                 background-color: rgba(0, 0, 0, 0.5); /* Fond semi-transparent */
                 z-index: 50; /* Placer le modal au-dessus du contenu */
                 justify-content: center;
                 align-items: center;
                 overflow-y: auto;
             }
     
             /* Contenu du modal */
             .modal-content {
                 margin: auto;
                 background-color: white;
                 padding: 20px;
                 border-radius: 10px;
                 width: 80%;
                 max-width: 600px;
             }
             body {
                 background-color:#f2f8ff;
             }
            
              /* Icône du gear */
         .gear-icon {
           font-size: 30px;
           cursor: pointer;
           position: relative; 
     
         }
     
         /* Style du menu */
         .menu {
           display: none; /* Initialement caché */
           position: absolute;
           top: 60px; /* Place le menu juste en dessous de l'icône */
           right:65px;
           background-color: #f9f9f9;
           border: 1px solid #ccc;
           padding: 5px;
           width:150px;
           border-radius: 5px;
           box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
           z-index: 10; /* Assure que le menu est au-dessus des autres éléments */
         }
     
         /* Style des éléments de menu */
         .menu a {
           display: block;
           background-color:#f2f8ff;
           margin-top:2px;
           color: #333;
           text-decoration: none;
         }
     
         .menu a:hover {
             background-color:rgb(185, 212, 243);
             cursor: pointer;
         }

    </style>
</head>

<body>

<header class="mx-4">
    <div class="container flex justify-between items-center">
        <!-- Logo avec taille augmentée -->
        <img src="../images/logo.png" alt="Logo" class="h-24 w-32"> <!-- Ajout de la classe "logo" pour appliquer la transformation -->
        <div class="space-x-6 items-center mr-8"> <!-- Espacement égal entre les éléments --> 
            <i class="fa-duotone fa-solid fa-gear gear-icon"style="color:#24508c;" onclick="toggleMenu()">
            </i> 
            <div class="menu" id="menu">
              <a onclick="ajouterCours()" class="text-center" style="color:#24508c">ajouter cours</a>
              <a href="deconnexion.php"  class="text-center hover:text-gray-400" style="color:#24508c">log out</a>
            </div>
        </div>
    </div>               
</header>
 
               
<div class="container p-6">
    
    <div class="flex justify-between items-center">
        <h2 class="text-3xl font-bold mb-4" style="color:#24508c">Mes Cours</h2>
        <div class="flex justify-center gap-5 my-4">
        <a href="users.php" style="color: rgb(185, 212, 243) ;background-color:#24508c;"  class="text-white py-2 px-3 rounded hover:bg-red-600">consultation</i></a>
        <a href="statisticsChef.php" style="color: rgb(185, 212, 243) ;background-color:#24508c;"  class="text-white py-2 px-3 rounded hover:bg-red-600">Statistiques</i></a>
        </div>
    </div>
 
    <!-- Affichage des cours -->
    <!-- <div class="container mx-auto">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            <?php foreach($projets as $project): ?>
                <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                    <a href="taches_view.php?id_projet=<?php echo $project['id_projet']; ?>">
                        <img class="rounded-t-lg" src="<?php echo $project['image_projet']; ?>" alt="" />
                    </a>
                    <div class="p-5">
                        <a href="#">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white" style="color:#24508c"><?php echo $project['nom_projet']; ?></h5>
                        </a>
                        <p class="mb-3 font-bold text-gray-700 dark:text-gray-400"><?php echo $project['desc_projet']; ?></p>
                        <p class="px-4 py-2"><?php echo $project['date_debut_projet']; ?>/<?php echo $project['date_fin_projet']; ?></p>
                        <p class="px-4 py-2" style="color:rgb(78, 109, 145) "><?php echo $project['visibilite_projet']; ?></p>
                        <form method="POST" action="modifier_projet.php" class="inline ml-2">
                            <input type="hidden" name="projet_id" value="<?php echo $project['id_projet']; ?>" />
                            <button type="submit" name="modifier" style="color: rgb(185, 212, 243) ;background-color:#24508c;" class="text-white py-2 px-3 rounded hover:bg-yellow-600"><i class="fa-solid fa-pen-to-square"></i></button>
                        </form>
                        <form method="POST" action="../controllers/supprimer_projet.php" class="inline ml-2">
                            <input type="hidden" name="projet_id" value="<?php echo $project['id_projet']; ?>" />
                            <button type="submit" name="supprimer" style="color: rgb(185, 212, 243) ;background-color:#24508c;"  class="text-white py-2 px-3 rounded hover:bg-red-600"><i class="fa-solid fa-trash"></i></button>
                        </form>
                        <form class="inline ml-1">
                           <a href="readme.php?project_id=<?php echo $project['id_projet']; ?>" style="color: rgb(185, 212, 243) ;background-color:#24508c;"  class="text-white py-2 px-2 rounded hover:bg-red-600 font-bold">MD</a>
                           <a href="taches_view.php?id_projet=<?php echo $project['id_projet']; ?>" style="color: rgb(185, 212, 243) ;background-color:#24508c;"  class="text-white font-bold p-2 px-2 rounded hover:bg-red-600 w-24 h-24">Planifier</a>
                        </form>

                    </div>
                </div>
                
            <?php endforeach; ?>
        </div>
    </div> -->

    <!-- Modal pour ajouter un cours -->
    <div class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50" id="modal">
        <form method="POST" class="bg-white p-4 rounded-lg shadow-xl w-full max-w-lg " style="background-color:#f2f8ff; border:5px solid #24508c">
            <div class="p-4 text-center text-white pt-2" style="height:70px; width:70px;position:relative; left:417px;bottom:21px; border-bottom-left-radius:90px; border-top-right-radius:9px;font-size:25px; background-color:#24508c;">
                <button><i class="fas fa-times"></i></button>
            </div>
           
            <!-- Champ URL image -->
            <div>
                <label for="photo_Cours" class="block text-gray-700 font-semibold">URL image:</label>
                <input type="url" name="photo_Cours" required class="w-full px-4 py-1 border border-gray-300 rounded-lg mt-2 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
            </div>
    
            <!-- Champ Nom du projet -->
            <div>
                <label for="nom_Cours" class="block text-gray-700 font-semibold">Titre du cours:</label>
                <input type="text" name="nom_Cours" required class="w-full px-4 py-2 border border-gray-300 rounded-lg mt-2 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
            </div>
    
            <!-- Champ Description -->
            <div>
                <label for="desc_Cours" class="block text-gray-700 font-semibold">Descriptionn du cours:</label>
                <textarea name="desc_Cours" class="w-full px-4 py-2 border border-gray-300 rounded-lg mt-2 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all"></textarea>
            </div>
            <!-- Champ Visibilité -->
            <div>
              
            </div>
            <!-- Bouton Ajouter le projet -->
            <button type="submit" name="ajouter" class="w-full text-white mt-4 py-2 px-4 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all" style="background-color:#24508c">Ajouter le cours</button>
        </form>
    </div>

    
   
 
</div>

<script>
    const modalProjet = document.getElementById('modal');
    const modalAssigner = document.getElementById('modal-assigner');

    function ajouterCours() {
        modalProjet.style.display = modalProjet.style.display === "flex" ? "none" : "flex"; // Toggle visibility
    }
    // Fermer le modal en cliquant en dehors du contenu
    window.addEventListener('click', function(event) {
        if (event.target === modalProjet) {
            modalProjet.style.display = "none";
        }
        if (event.target === modalAssigner) {
            modalAssigner.style.display = "none";
        }
    });

      // Fonction pour afficher/cacher le menu
      function toggleMenu() {
      const menu = document.getElementById("menu");
      if (menu.style.display === "none") {
        menu.style.display = "block"; // Si le menu est visible, on le cache
      } else {
        menu.style.display = "none"; // Sinon on l'affiche
      }
    };
</script>

</body>

</html>