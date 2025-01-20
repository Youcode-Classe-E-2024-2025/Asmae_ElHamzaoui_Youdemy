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
            background-color:white;
            overflow-x: hidden;
        }

        canvas {
            display: block;
            height:500px;
            width: 100%;
            background-color: #dadfdc;    
        }
    </style>
</head>

<body>

    <!-- Header -->
   <?php 
   include_once 'header.php';
   ?>

    <!-- Section du canvas -->
    <section class="py-6 mt-2">
        <canvas id="monCanvas"></canvas>
    </section>

    <!-- Contact Us Section -->
    <section class="bg-gray-100 w-full py-16 px-6" id="contact-us">
        <div class="mx-auto text-center">
            <h2 class="text-4xl font-semibold text-gray-800 mb-6">Contactez-nous</h2>
            <p class="text-lg text-gray-600 mb-8">Nous serions heureux de recevoir vos questions ou commentaires.</p>
            <form action="#" method="POST" class="max-w-lg mx-auto space-y-6">
                <input type="text" name="name" placeholder="Votre nom" class="w-full p-4 border border-gray-300 rounded-md">
                <input type="email" name="email" placeholder="Votre email" class="w-full p-4 border border-gray-300 rounded-md">
                <textarea name="message" placeholder="Votre message" rows="4" class="w-full p-4 border border-gray-300 rounded-md"></textarea>
                <button type="submit" class="w-full bg-green-500 text-white py-3 rounded-md hover:bg-green-600 font-bold" style="background-color:#1c4933">Envoyer</button>
            </form>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-8" style="background-color:#1c4933">
        <div class="max-w-screen-xl text-center text-white">
            <p>&copy; 2025 Votre entreprise. Tous droits réservés.</p>
        </div>
    </footer>
    <script src="../assets/home.js"></script>
</body>
</html>
