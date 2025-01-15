<?php


// Connexion à la base de données
require_once '../model/user.php';

//récupérer les professeurs
$professeurs = user::getProfesseurs($pdo);  // Appel statique de la méthode pour récupérer les professeurs

//récupérer les utilisateurs
$utilisateurs = user::getAllUsers($pdo);

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
                                <a href="#" class="p-2 hover:bg-gray-800 text-white text-sm no-underline hover:no-underline block"><i class="fas fa-sign-out-alt fa-fw"></i> Log Out</a>
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
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Analytics Section -->
        <section id="analytics" class="section">
            <div id="main" class="main-content flex-1 bg-gray-100 ml-8 md:mt-2 pb-24 md:pb-5" style="margin-top:40px ; min-width:100%">
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
                                    <h2 class="font-bold uppercase text-gray-600">Total Revenue</h2>
                                   <p class="font-bold text-3xl">$3249 <span class="text-green-500"><i class="fas fa-caret-up"></i></span></p>
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
                                    <h2 class="font-bold uppercase text-gray-600">Total Users</h2>
                                    <p class="font-bold text-3xl">249 <span class="text-pink-500"><i class="fas fa-exchange-alt"></i></span></p>
                                </div>
                            </div>
                        </div>
                        <!--/Metric Card-->
                    </div>
                    <div class="w-full md:w-1/2 xl:w-1/3 p-6">
                        <!--Metric Card-->
                        <div class="bg-gradient-to-b from-yellow-200 to-yellow-100 border-b-4 border-yellow-600 rounded-lg shadow-xl p-5">
                            <div class="flex flex-row items-center">
                                <div class="flex-shrink pr-4">
                                    <div class="rounded-full p-5 bg-yellow-600"><i class="fas fa-user-plus fa-2x fa-inverse"></i></div>
                                </div>
                                <div class="flex-1 text-right md:text-center">
                                    <h2 class="font-bold uppercase text-gray-600">New Users</h2>
                                    <p class="font-bold text-3xl">2 <span class="text-yellow-600"><i class="fas fa-caret-up"></i></span></p>
                                </div>
                            </div>
                        </div>
                        <!--/Metric Card-->
                    </div>
                </div>


                <div class="flex flex-row flex-wrap flex-grow mt-12">

                    <div class="w-full md:w-1/2 xl:w-1/3 p-6">
                        <!--Graph Card-->
                        <div class="bg-white border-transparent rounded-lg shadow-xl">
                            <div class="bg-gradient-to-b from-gray-300 to-gray-100 uppercase text-gray-800 border-b-2 border-gray-300 rounded-tl-lg rounded-tr-lg p-2">
                                <h class="font-bold uppercase text-gray-600">Graph</h>
                            </div>
                            <div class="p-5">
                                <canvas id="chartjs-7" class="chartjs" width="undefined" height="undefined"></canvas>
                                <script>
                                    new Chart(document.getElementById("chartjs-7"), {
                                        "type": "bar",
                                        "data": {
                                            "labels": ["January", "February", "March", "April"],
                                            "datasets": [{
                                                "label": "Page Impressions",
                                                "data": [10, 20, 30, 40],
                                                "borderColor": "rgb(255, 99, 132)",
                                                "backgroundColor": "rgba(255, 99, 132, 0.2)"
                                            }, {
                                                "label": "Adsense Clicks",
                                                "data": [5, 15, 10, 30],
                                                "type": "line",
                                                "fill": false,
                                                "borderColor": "rgb(54, 162, 235)"
                                            }]
                                        },
                                        "options": {
                                            "scales": {
                                                "yAxes": [{
                                                    "ticks": {
                                                        "beginAtZero": true
                                                    }
                                                }]
                                            }
                                        }
                                    });
                                </script>
                            </div>
                        </div>
                        <!--/Graph Card-->
                    </div>
    
                    <div class="w-full md:w-1/2 xl:w-1/3 p-6">
                        <!--Graph Card-->
                        <div class="bg-white border-transparent rounded-lg shadow-xl">
                            <div class="bg-gradient-to-b from-gray-300 to-gray-100 uppercase text-gray-800 border-b-2 border-gray-300 rounded-tl-lg rounded-tr-lg p-2">
                                <h2 class="font-bold uppercase text-gray-600">Graph</h2>
                            </div>
                            <div class="p-5">
                                <canvas id="chartjs-0" class="chartjs" width="undefined" height="undefined"></canvas>
                                <script>
                                    new Chart(document.getElementById("chartjs-0"), {
                                        "type": "line",
                                        "data": {
                                            "labels": ["January", "February", "March", "April", "May", "June", "July"],
                                            "datasets": [{
                                                "label": "Views",
                                                "data": [65, 59, 80, 81, 56, 55, 40],
                                                "fill": false,
                                                "borderColor": "rgb(75, 192, 192)",
                                                "lineTension": 0.1
                                            }]
                                        },
                                        "options": {}
                                    });
                                </script>
                            </div>
                        </div>
                        <!--/Graph Card-->
                    </div>

                    <div class="w-full md:w-1/2 xl:w-1/3 p-6">
                        <!--Graph Card-->
                        <div class="bg-white border-transparent rounded-lg shadow-xl">
                            <div class="bg-gradient-to-b from-gray-300 to-gray-100 uppercase text-gray-800 border-b-2 border-gray-300 rounded-tl-lg rounded-tr-lg p-2">
                                <h2 class="font-bold uppercase text-gray-600">Graph</h2>
                            </div>
                            <div class="p-5">
                                <canvas id="chartjs-1" class="chartjs" width="undefined" height="undefined"></canvas>
                                <script>
                                    new Chart(document.getElementById("chartjs-1"), {
                                        "type": "bar",
                                        "data": {
                                            "labels": ["January", "February", "March", "April", "May", "June", "July"],
                                            "datasets": [{
                                                "label": "Likes",
                                                "data": [65, 59, 80, 81, 56, 55, 40],
                                                "fill": false,
                                                "backgroundColor": ["rgba(255, 99, 132, 0.2)", "rgba(255, 159, 64, 0.2)", "rgba(255, 205, 86, 0.2)", "rgba(75, 192, 192, 0.2)", "rgba(54, 162, 235, 0.2)", "rgba(153, 102, 255, 0.2)", "rgba(201, 203, 207, 0.2)"],
                                                "borderColor": ["rgb(255, 99, 132)", "rgb(255, 159, 64)", "rgb(255, 205, 86)", "rgb(75, 192, 192)", "rgb(54, 162, 235)", "rgb(153, 102, 255)", "rgb(201, 203, 207)"],
                                                "borderWidth": 1
                                            }]
                                        },
                                        "options": {
                                            "scales": {
                                                "yAxes": [{
                                                    "ticks": {
                                                        "beginAtZero": true
                                                    }
                                                }]
                                            }
                                        }
                                    });
                                </script>
                            </div>
                        </div>
                        <!--/Graph Card-->
                    </div>

                </div>
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
                                        <th class="px-6 py-4 text-left">content</th>
                                        <th class="px-6 py-4 text-left">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-700">
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="px-6 py-4 hidden">1</td>
                                        <td class="px-6 py-4">Alice Dupont</td>
                                        <td class="px-6 py-4">25</td>
                                        <td class="px-6 py-4">Paris</td>
                                        <td class="px-6 py-4">
                                            <button class="text-blue-500 hover:text-blue-700"><i class="fa-solid fa-user-check"></i></button>
                                            <button class="text-red-500 hover:text-red-700 ml-2"><i class="fa-solid fa-trash"></i></button>
                                        </td>
                                    </tr>
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
                                            <button class="text-blue-500 hover:text-blue-700"><i class="fa-solid fa-user-check"></i></button>
                                            <button class="text-red-500 hover:text-red-700 ml-2"><i class="fa-solid fa-trash"></i></button>
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
                                        <th class="px-6 py-4 text-left">activation</th>
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
                                        <td class="px-6 py-4"><?php echo $user['is_valid'] ;?></td>
                                        <td class="px-6 py-4">
                                            <button class="text-blue-500 hover:text-blue-700">Active</button>
                                            <button class="text-red-500 hover:text-red-700 ml-2"><i class="fa-solid fa-trash"></i></button>
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
    </div>
</main>




<script>
    /*Toggle dropdown list*/
    function toggleDD(myDropMenu) {
        document.getElementById(myDropMenu).classList.toggle("invisible");
    }
    /*Filter dropdown options*/
    function filterDD(myDropMenu, myDropMenuSearch) {
        var input, filter, ul, li, a, i;
        input = document.getElementById(myDropMenuSearch);
        filter = input.value.toUpperCase();
        div = document.getElementById(myDropMenu);
        a = div.getElementsByTagName("a");
        for (i = 0; i < a.length; i++) {
            if (a[i].innerHTML.toUpperCase().indexOf(filter) > -1) {
                a[i].style.display = "";
            } else {
                a[i].style.display = "none";
            }
        }
    }
    // Close the dropdown menu if the user clicks outside of it
    window.onclick = function(event) {
        if (!event.target.matches('.drop-button') && !event.target.matches('.drop-search')) {
            var dropdowns = document.getElementsByClassName("dropdownlist");
            for (var i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (!openDropdown.classList.contains('invisible')) {
                    openDropdown.classList.add('invisible');
                }
            }
        }
    }


     // Fonction pour afficher la section correspondante
     function showSection(section) {
        // Masquer toutes les sections
        const sections = document.querySelectorAll('.section');
        sections.forEach(function (sec) {
            sec.classList.add('hidden');
        });

        // Afficher la section demandée
        const sectionToShow = document.getElementById(section);
        if (sectionToShow) {
            sectionToShow.classList.remove('hidden');
        }
    }

    // Attendez que le DOM soit complètement chargé avant d'exécuter le script
    document.addEventListener('DOMContentLoaded', function () {
        // Afficher la section Analytics par défaut après le chargement de la page
        showSection('analytics');
    });
</script>


</body>
</html>