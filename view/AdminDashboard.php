<?php

session_start();
if(!isset($_SESSION['user_id'])){
    echo "vous devez etre connecter";
    exit;
}
require_once '../config/db.php';
require_once '../model/cours.php'; 
require_once '../model/user.php';
require_once '../model/categorie.php';

//récupérer les professeurs
$professeurs = user::getProfesseurs($pdo);  // Appel statique de la méthode pour récupérer les professeurs

//récupérer les utilisateurs
$utilisateurs = user::getAllUsers($pdo);

// Récupérer tous les cours depuis la base de données
$stmt = $pdo->query("SELECT * FROM cours");
$coursData = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare('select * from tags');
$stmt->execute();
$tags = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt1 = $pdo->prepare('select * from categories');
$stmt1->execute();
$categories = $stmt1->fetchAll(PDO::FETCH_ASSOC);

// total des cours 
$stmt2 = $pdo->prepare('SELECT COUNT(*) AS total_cours FROM cours');
$stmt2->execute();
$resultat2 = $stmt2->fetch();
$totalCours = $resultat2['total_cours'];  // Correction du nom de la clé

// catégorie qui a plus de cours
$stmt3 = $pdo->prepare('SELECT c.name_categorie, COUNT(co.id_cours) AS nombre_cours
FROM categories c
JOIN cours co ON c.id_categorie = co.id_categorie
GROUP BY c.id_categorie
ORDER BY nombre_cours DESC LIMIT 1');
$stmt3->execute();
$row = $stmt3->fetch();



//  Le cours avec le plus d'étudiants inscrits
// $stmt4 = $pdo->prepare('SELECT co.id_cours, co.titre_cours, COUNT(i.id_user) AS nombre_etudiants
// FROM cours co
// JOIN inscription i ON co.id_cours = i.id_cours
// GROUP BY co.id_cours
// ORDER BY nombre_etudiants DESC
// LIMIT 1');
// $stmt4->execute();
// $resultat4 = $stmt4->fetch();
// $titreCours = $resultat4['titre_cours'];
// $nombreEtudiants = $resultat4['nombre_etudiants'];


//   Les Top 3 enseignants 
$stmt5 = $pdo->prepare("SELECT u.id_user, u.user_name, COUNT(DISTINCT co.id_cours) AS total_cours, COUNT(DISTINCT i.id_user) AS total_etudiants
FROM user u
JOIN cours co ON u.id_user = co.id_user
LEFT JOIN inscription i ON co.id_cours = i.id_cours
WHERE u.user_role = 'Enseignant' 
GROUP BY u.id_user
ORDER BY total_etudiants DESC, total_cours DESC
LIMIT 3;");
$stmt5->execute();
$resultats5 = $stmt5->fetchAll();





?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tailwind Admin Starter Template : Tailwind Toolbox</title>
    <meta name="author" content="name">
    <meta name="description" content="description here">
    <meta name="keywords" content="keywords,here">
    <script src="../assets/admin.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css"/> <!--Replace with your tailwind.css once created-->
    <link href="https://afeld.github.io/emoji-css/emoji.css" rel="stylesheet"> <!--Totally optional :) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js" integrity="sha256-xKeoJ50pzbUGkpQxDYHD7o7hxe0LaOGeguUidbq6vis=" crossorigin="anonymous"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color:white;
            overflow-x: hidden;
        }
</style>
</head>

<body style="background-color: #dadfdc;" class="mt-12">

<header>
    <!--Nav-->
    <nav aria-label="menu nav" class="bg-gray-800 p-1 md:pt-1  px-1 mt-0 h-auto fixed w-full z-20 top-0">
        <div class="flex justify-between">
            <div class="flex flex-shrink md:w-1/3 justify-center md:justify-start text-white">
                <a href="#" aria-label="Home">
                    <span class="text-xl pl-2"><img src="../assets/images/logoB.png" alt="Logo" class="h-12 w-12 ml-2 pb-4"></span>
                </a>
            </div>
            <div class="flex w-full pt-2 content-center justify-end md:w-1/3 md:justify-end">
                <ul class="list-reset flex justify-between flex-1 md:flex-none items-center">
                    <li class="flex-1 md:flex-none md:mr-3">
                        <a class="inline-block py-2 px-4 text-white no-underline" href="#">Active</a>
                    </li>
                    <li class="flex-1 md:flex-none md:mr-3">
                        <div class="relative inline-block">
                            <button onclick="toggleDD('myDropdown')" class="drop-button text-white py-2 px-2"> <span class="pr-2"><i class="em em-robot_face"></i></span> Hi, Admin <svg class="h-3 fill-current inline" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" /></svg></button>
                            <div id="myDropdown" class="dropdownlist absolute bg-gray-800 text-white right-0 mt-3 p-3 overflow-auto z-30 invisible">
                                <a href="#" class="p-2 hover:bg-gray-800 text-white text-sm no-underline hover:no-underline block"><i class="fa fa-cog fa-fw"></i> Settings</a>
                                <div class="border border-gray-800"></div>
                                <a href="deconnexion.php" class="p-2 hover:bg-gray-800 text-white text-sm no-underline hover:no-underline block"><i class="fas fa-sign-out-alt fa-fw"></i> Log Out</a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>


<main>
    <div class="flex flex-col md:flex-row">
        <nav aria-label="alternative nav">
            <div class="rounded-tr-3xl bg-gray-800 shadow-xl h-20 fixed bottom-0 mt-12 md:relative md:h-screen z-10 w-full md:w-48 content-center">
                <div class="md:mt-20 md:w-48 md:fixed md:left-0 md:top-0 content-center md:content-start text-left justify-between">
                    <ul class="list-reset flex flex-row md:flex-col pt-3 md:py-3 px-1 md:px-2 text-center md:text-left">
                        <li class="mr-3 flex-1">
                            <a href="#" onclick="showSection('analytics')" class="block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 border-blue-600">
                                <i class="fas fa-chart-area pr-0 md:pr-3 text-blue-600"></i><span class="pb-1 md:pb-0 text-xs md:text-base text-white md:text-white block md:inline-block">Analytics</span>
                            </a>
                        </li>
                        <li class="mr-3 flex-1">
                            <a href="#" onclick="showSection('cours')" class="block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 border-gray-800 hover:border-pink-500">
                                <i class="fa-solid fa-book pr-0 md:pr-3"></i><span class="pb-1 md:pb-0 text-xs md:text-base text-gray-400 md:text-gray-200 block md:inline-block">Cours</span>
                            </a>
                        </li>
                        <li class="mr-3 flex-1">
                            <a href="#" onclick="showSection('professor')" class="block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 border-gray-800 hover:border-purple-500">
                                <i class="fa-solid fa-user-tie pr-0 md:pr-3"></i></i><span class="pb-1 md:pb-0 text-xs md:text-base text-gray-400 md:text-gray-200 block md:inline-block">Professors</span>
                            </a>
                        </li>
                        <li class="mr-3 flex-1">
                            <a href="#" onclick="showSection('user')" class="block py-1 md:py-3 pl-0 md:pl-1 align-middle text-white no-underline hover:text-white border-b-2 border-gray-800 hover:border-red-500">
                                <i class="fa-solid fa-users pr-0 md:pr-3"></i><span class="pb-1 md:pb-0 text-xs md:text-base text-gray-400 md:text-gray-200 block md:inline-block">Users</span>
                            </a>
                        </li>
                        <li class="mr-3 flex-1">
                            <a href="#" onclick="showSection('tags')" class="block py-1 md:py-3 pl-0 md:pl-1 align-middle text-white no-underline hover:text-white border-b-2 border-gray-800 hover:border-red-500">
                                <i class="fa-solid fa-users pr-0 md:pr-3"></i><span class="pb-1 md:pb-0 text-xs md:text-base text-gray-400 md:text-gray-200 block md:inline-block">Tags</span>
                            </a>
                        </li>
                        <li class="mr-3 flex-1">
                            <a href="#" onclick="showSection('categorise')" class="block py-1 md:py-3 pl-0 md:pl-1 align-middle text-white no-underline hover:text-white border-b-2 border-gray-800 hover:border-red-500">
                                <i class="fa-solid fa-users pr-0 md:pr-3"></i><span class="pb-1 md:pb-0 text-xs md:text-base text-gray-400 md:text-gray-200 block md:inline-block">Categorise</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Analytics Section -->
        <section id="analytics" class="section">
            <div id="main" class="main-content flex-1 bg-gray-100 ml-8 md:mt-2 pb-24 md:pb-5" style="margin-top:40px ; min-width:100%;">
                <div class="pt-3" style="background-color: #dadfdc;">
                    <div class="rounded-tl-3xl rounded-tr-3xl bg-gradient-to-r from-green-900 to-gray-800 p-4 shadow text-2xl text-white">
                        <h1 class="font-bold pl-2">Analytics</h1>
                    </div>
                </div>

                <div class="flex flex-wrap">
                    <div class="w-full md:w-1/2 xl:w-1/3 p-6">
                        <!--Metric Card-->
                        <div class="bg-gradient-to-b from-green-200 to-green-100 border-b-4 border-green-600 rounded-lg shadow-xl p-5">
                            <div class="flex flex-row items-center">
                                <div class="flex-shrink pr-4">
                                    <div class="rounded-full p-5 bg-green-600"><i class="fa fa-wallet fa-2x fa-inverse"></i></div>
                                </div>
                                <div class="flex-1 text-right md:text-center">
                                    <h2 class="font-bold uppercase text-gray-600">3 top enseignant</h2>
                                   <p>
                                    <?php 
                                       foreach ($resultats5 as $row2) {
                                        // Afficher les informations de chaque enseignant
                                           echo '-' . $row2['user_name'];
                                        }?>
                                     <span class="text-green-500"><i class="fas fa-caret-up"></i></span></p>
                                </div>
                            </div>
                        </div>
                        <!--/Metric Card-->
                    </div>
                    <div class="w-full md:w-1/2 xl:w-1/3 p-6">
                        <!--Metric Card-->
                        <div class="bg-gradient-to-b from-pink-200 to-pink-100 border-b-4 border-pink-500 rounded-lg shadow-xl p-5">
                            <div class="flex flex-row items-center">
                                <div class="flex-shrink pr-4">
                                    <div class="rounded-full p-5 bg-pink-600"><i class="fas fa-users fa-2x fa-inverse"></i></div>
                                </div>
                                <div class="flex-1 text-right md:text-center">
                                    <h2 class="font-bold uppercase text-gray-600"> <?php echo 'Catégorie : '.$row['name_categorie'];?></h2>
                                    <?php echo 'Nombre de cours : '.$row['nombre_cours'];?>
                                    <span class="text-pink-500"><i class="fas fa-exchange-alt"></i></span>
                                </div>
                            </div>
                        </div>
                        <!--/Metric Card-->
                    </div>
                    <div class="w-full md:w-1/2 xl:w-1/3 p-5">
                        <!--Metric Card-->
                        <div class="bg-gradient-to-b from-yellow-200 to-yellow-100 border-b-4 border-yellow-600 rounded-lg shadow-xl p-5">
                            <div class="flex flex-row items-center">
                                <div class="flex-shrink">
                                    <div class="rounded-full p-3 bg-yellow-600"><i class="fas fa-user-plus fa-2x fa-inverse"></i></div>
                                </div>
                                <div class="flex-1 text-right md:text-center">
                                    <h2 class="font-bold uppercase text-gray-600"><?php echo 'Cours :2'  ;?> <span class="text-yellow-600"><i class="fas fa-caret-up"></i></span></h2>
                                    <?php echo 'total étudiant : 3';?>
                                </div>
                            </div>
                        </div>
                        <!--/Metric Card-->
                    </div>
                </div>


                <h2 class="text-center mt-[30px]">Graphiques : Distribution des cours, Professeurs et Etudiants</h2>
                <section class="flex mt-[80px] justify-center">
                   <canvas id="pieChart" style="width:50%;max-width:400px;"></canvas>
                </section>
           </div>
        </section>

        <!-- Cours Section -->
        <section id="cours" class="section hidden w-full">
            <div id="main" class="mx-4 main-content flex-1 bg-gray-100 ml-8 md:mt-2 pb-24 md:pb-5" style="margin-top:40px;">
                <div class="pt-3" style="background-color: #dadfdc;">
                    <div class="rounded-tl-3xl rounded-tr-3xl bg-gradient-to-r from-green-900 to-gray-800 p-4 shadow text-2xl text-white">
                        <h1 class="font-bold pl-2">Cours</h1>
                    </div>
                </div>
                <div class="flex flex-row flex-wrap flex-grow mt-6">
                    <div class="container p-4">
                        <div class="overflow-x-auto bg-white rounded-lg shadow-lg">
                            <table class="min-w-full table-auto">
                                <thead class="bg-gray-800 text-white">
                                    <tr>
                                        <th class="px-6 py-4 text-left hidden">#</th>
                                        <th class="px-6 py-4 text-left">Titre</th>
                                        <th class="px-6 py-4 text-left">description</th>
                                        <th class="px-6 py-4 text-left">catégorie</th>
                                        <th class="px-6 py-4 text-left">tags</th>
                                        <th class="px-6 py-4 text-left">action</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-700">
                                <?php foreach ($coursData as $course): ?>
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="px-6 py-4 hidden"></td>
                                        <td class="px-6 py-4"><?php echo htmlspecialchars($course['titre_cours']); ?></td>
                                        <td class="px-6 py-4"><?php echo htmlspecialchars($course['desc_cours']); ?></td>
                                        <td class="px-6 py-4"><?php echo htmlspecialchars($course['desc_cours']); ?></td>
                                        <td class="px-6 py-4">Paris</td>
                                        <td class="px-6 py-4">
                                            <form method="POST" action="../controller/supprimer_courAdmin.php" class="inline ml-2">
                                              <input type="hidden" name="cours_id" value="<?php echo $course['id_cours']; ?>" />
                                              <button type="submit" name="supprimer" class="text-red-500 hover:text-red-700 ml-2"><i class="fa-solid fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
           </div>
        </section>         
        
        <!-- Professor Section -->
        <section id="professor" class="section hidden w-full">
            <div id="main" class="mx-4 main-content flex-1 bg-gray-100 ml-8 md:mt-2 pb-24 md:pb-5" style="margin-top:40px;">
                <div class="pt-3" style="background-color: #dadfdc;">
                    <div class="rounded-tl-3xl rounded-tr-3xl bg-gradient-to-r from-green-900 to-gray-800 p-4 shadow text-2xl text-white">
                        <h1 class="font-bold pl-2">Professor</h1>
                    </div>
                </div>
                <div class="flex flex-row flex-wrap flex-grow mt-6">
                    <div class="container p-4">
                        <div class="overflow-x-auto bg-white rounded-lg shadow-lg">
                            <table class="min-w-full table-auto">
                                <thead class="bg-gray-800 text-white">
                                    <tr>
                                        <th class="px-6 py-4 text-left hidden">#</th>
                                        <th class="px-6 py-4 text-left">Nom</th>
                                        <th class="px-6 py-4 text-left">Email</th>
                                        <th class="px-6 py-4 text-left">Statut</th>
                                        <th class="px-6 py-4 text-left">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-700">
                                    <?php foreach($professeurs as $prof):?>
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="px-6 py-4 hidden"></td>
                                        <td class="px-6 py-4"><?php echo $prof['user_name'] ;?></td>
                                        <td class="px-6 py-4"><?php echo $prof['user_email'] ; ?></td>
                                        <td class="px-6 py-4"><?php echo $prof['is_valid'] ; ?></td>
                                        <td class="px-6 py-4">
                                            <form method="POST" action="../controller/confirmationUser.php" class="inline ml-2">
                                                   <input type="hidden" name="user_id" value="<?php echo $prof['id_user']; ?>" />
                                                   <button type="submit" name="changer" style="background-color:rgb(185, 212, 243);" onclick="return confirm('Êtes-vous sûr de vouloir changer le statut de cet utilisateur ?')"
                                                    class="text-white py-2 px-3 rounded hover:bg-red-600"><i class="fa-solid fa-user-check"></i></button>
                                            </form>
                                            <form method="POST" action="../controller/supprimerProf.php" class="inline ml-2">
                                                    <input type="hidden" name="user_id" value="<?php echo $prof['id_user']; ?>" />
                                                    <button type="submit" name="supprimer" style="background-color:rgb(185, 212, 243);"  onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ? Cette action est irréversible.')"
                                                     class="text-white py-2 px-3 rounded hover:bg-red-600"><i class="fa-solid fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
           </div>
        </section>
                 
                
         <!-- User Section -->     
        <section  id="user" class="section hidden w-full">
            <div id="main" class="mx-4 main-content flex-1 bg-gray-100 ml-8 md:mt-2 pb-24 md:pb-5" style="margin-top:40px;">
                <div class="pt-3" style="background-color: #dadfdc;">
                    <div class="rounded-tl-3xl rounded-tr-3xl bg-gradient-to-r from-green-900 to-gray-800 p-4 shadow text-2xl text-white">
                        <h1 class="font-bold pl-2">Users</h1>
                    </div>
                </div>
                <div class="flex flex-row flex-wrap flex-grow mt-6">
                    <div class="container p-4">
                        <div class="overflow-x-auto bg-white rounded-lg shadow-lg">
                            <table class="min-w-full table-auto">
                                <thead class="bg-gray-800 text-white">
                                    <tr>
                                        <th class="px-6 py-4 text-left hidden">#</th>
                                        <th class="px-6 py-4 text-left">Nom</th>
                                        <th class="px-6 py-4 text-left">Email</th>
                                        <th class="px-6 py-4 text-left">Role</th>
                                        <th class="px-6 py-4 text-left">Activation</th>
                                        <th class="px-6 py-4 text-left">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-700">
                                    <?php foreach($utilisateurs as $user):?>
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="px-6 py-4 hidden"></td>
                                        <td class="px-6 py-4"><?php echo $user['user_name'] ;?></td>
                                        <td class="px-6 py-4"><?php echo $user['user_email'] ;?></td>
                                        <td class="px-6 py-4"><?php echo $user['user_role'] ;?></td>
                                        <td class="px-6 py-4"><?php echo $user['status'] ;?></td>
                                        <td class="px-6 py-4">

                                            <form method="POST" action="../controller/activationUser.php" class="inline ml-2">
                                                   <input type="hidden" name="user_id" value="<?php echo $user['id_user']; ?>" />
                                                   <button type="submit" name="changer" style="background-color:rgb(185, 212, 243);" onclick="return confirm('Êtes-vous sûr de vouloir de déactiver ou activer cet utilisateur ?')"
                                                    class="text-white py-2 px-3 rounded hover:bg-red-600">Active</button>
                                            </form>
                                            <form method="POST" action="../controller/supprimerUser.php" class="inline ml-2">
                                                    <input type="hidden" name="user_id" value="<?php echo $user['id_user']; ?>" />
                                                    <button type="submit" name="supprimer" style="background-color:rgb(185, 212, 243);" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ? Cette action est irréversible.')"
                                                     class="text-white py-2 px-3 rounded hover:bg-red-600"><i class="fa-solid fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
           </div>
        </section>
  

       <!-- section Tags -->
        <section id="tags" class="section hidden w-full">
                <div id="main" class="mx-4 main-content flex-1 bg-gray-100 ml-8 md:mt-2 pb-24 md:pb-5" style="margin-top:40px;">
                    <div class="pt-3" style="background-color: #dadfdc;">
                        <div class="flex justify-between rounded-tl-3xl rounded-tr-3xl bg-gradient-to-r from-green-900 to-gray-800 p-4 shadow text-2xl text-white">
                            <h1 class="font-bold pl-2">Tags</h1>
                            <button class="pl-2 bg-black">Ajouter tags</button>
                        </div>
                    </div>
                    <div>
                        <form action="../controller/tagController.php" method="POST">
                            <div class="container mx-auto p-6 max-w-lg bg-white rounded-lg shadow-lg">
                                <h1 class="text-2xl font-semibold mb-4 text-center text-gray-800">Ajouter des tags</h1>
                                <!-- Champ pour saisir les tags -->
                                <input id="tags-input" name="tags" placeholder="Add tags (séparés par des virgules)" 
                                       class="w-full px-4 py-2 mb-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                                <!-- Champ caché pour envoyer les tags sous forme de texte -->
                                <input type="hidden" id="tags-hidden" name="tags_hidden" />
                                <!-- Bouton pour soumettre -->
                                <button type="submit" id="submit" 
                                        class="w-full py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    Submit
                                </button>
                            </div>
                        </form>
                    </div>
            
            
                    <div class="tags" id="tags-display">
                            <?php foreach ($tags as $tag): ?>
                                <span class="tag">#<?= $tag['name_tags'] ?></span>
                            <?php endforeach; ?>
                        </div>
                </div>
        </section>



         <!-- section categories -->
         <section i id="categorise" class="section hidden w-full">
                <div id="main" class="mx-4 main-content flex-1 bg-gray-100 ml-8 md:mt-2 pb-24 md:pb-5" style="margin-top:40px;">
                    <div class="pt-3" style="background-color: #dadfdc;">
                        <div class="flex justify-between rounded-tl-3xl rounded-tr-3xl bg-gradient-to-r from-green-900 to-gray-800 p-4 shadow text-2xl text-white">
                            <h1 class="font-bold pl-2">Categories</h1>
                            <button class="pl-2 bg-black">Ajouter categorie</button>
                        </div>
                    </div>
                    <div>
                        <form action="../controller/categorieController.php" method="POST">
                            <div class="container mx-auto p-6 max-w-lg bg-white rounded-lg shadow-lg">
                                <h1 class="text-2xl font-semibold mb-4 text-center text-gray-800">Ajouter des catégories</h1>
                                <!-- Champ pour saisir les categorie-->
                                <input id="categorie-input" name="categories" placeholder="Ajouter categories" 
                                       class="w-full px-4 py-2 mb-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                                <!-- Champ caché pour envoyer les tags sous forme de texte -->
                                <input type="hidden" id="categories-hidden" name="categories_hidden" />
                                <!-- Bouton pour soumettre -->
                                <button type="submit" id="submit2" 
                                        class="w-full py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    Submit
                                </button>
                            </div>
                        </form>
                    </div>
            
            
                    <div class="categories" id="categories-display">
                            <?php foreach ($categories as $categorie): ?>
                                <span class="categorie">#<?= $categorie['name_categorie'] ?></span>
                            <?php endforeach; ?>
                        </div>
                </div>
        </section>
    
    </div>
</main>
<script>
 // Initialisation de Tagify pour les tags
    const tagInput = new Tagify(document.getElementById('tags-input'));
 
// Au clic sur le bouton de soumission
   document.getElementById('submit').addEventListener('click', function (event) {
    // Récupère les tags ajoutés et crée un tableau de leurs valeurs
    const tags = tagInput.value.map(tag => tag.value);

    // Vérifie si au moins un tag a été ajouté
    if (tags.length === 0) {
        alert('Veuillez ajouter au moins un tag');
        event.preventDefault(); // Empêche la soumission du formulaire si aucun tag n'est ajouté
        return;
    }

    // Remplir le champ caché avec les valeurs des tags
    document.getElementById('tags-hidden').value = JSON.stringify(tags);
});


 // Initialisation de Tagify pour les catégories
 const categorieInput = new Tagify(document.getElementById('categorie-input'));

// Au clic sur le bouton de soumission
document.getElementById('submit2').addEventListener('click', function (event) {
    // Récupère les tags ajoutés et crée un tableau de leurs valeurs
    const categories = categorieInput.value.map(categorie => categorie.value);

    // Vérifie si au moins un tag a été ajouté
    if (categories.length === 0) {
        alert('Veuillez ajouter au moins un tag');
        event.preventDefault(); // Empêche la soumission du formulaire si aucun tag n'est ajouté
        return;
    }

    // Remplir le champ caché avec les valeurs des tags
    document.getElementById('categories-hidden').value = JSON.stringify(categories);
});

</script>

<script>
    // Récupérer les données PHP dans JavaScript
    var xValues = ['Cours'];
    var yValues = [<?php echo $totalCours; ?>];
    var barColors = ['blue'];

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
                text: "Nombre total des cours"
            }
        }
    });

   
</script>
</body>
</html>