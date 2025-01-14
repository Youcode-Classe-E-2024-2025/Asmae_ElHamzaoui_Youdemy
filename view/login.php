<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="../assets/login.js"></script>    
    <style>
        /* Tu peux garder ton CSS personnalisé ici si nécessaire */
    </style>
</head>
<body>

    <div class="flex justify-center items-center min-h-screen">
        <div class="bg-indigo-950 p-4 rounded-lg shadow-lg w-full sm:w-[700px] grid grid-cols-1 sm:grid-cols-2 gap-8" style="background-color: #dadfdc;  box-shadow: 0 4px 12px rgba(23, 60, 17, 0.62);">

            <!-- Section gauche (image et texte) -->
            <div class="flex flex-col justify-center items-center sm:items-start mb-10">
                <img src="../assets/images/logoB.png" alt="Logo" class="h-24 w-34 ml-24">
                <p class="font-bold sm:text-left text-black mt-6 ml-10">Veuillez vous connecter pour</p>
                <p class="font-bold sm:text-left text-black ml-14">accéder à votre compte.</p>
            </div>

            <!-- Section droite (formulaire d'inscription) -->
            <div>
                <form id="loginForm" action="../controllers/loginController.php" method="POST" onsubmit="return validateLoginForm()">
                    
                    <!-- Récupération des informations utilisateur -->
                    <div class="mb-4">
                        <label for="email" class="block text-black">Email:</label>
                        <input type="email" id="email" name="email" class="w-full p-3 mt-1 border border-1 rounded-md focus:outline-none focus:ring-2 focus:ring-green-800" style="border-color:#1c4933" placeholder="Email" required>
                        <span id="emailError" class="text-red-500 text-sm"><?= $errors['email'] ?? '' ?></span>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="block text-black">Mot de passe:</label>
                        <input type="password" id="password" name="password" class="w-full p-3 mt-1 border border-1 rounded-md focus:outline-none focus:ring-2 focus:ring-green-800" style="border-color:#1c4933" placeholder="Mot de passe" required>
                        <span id="passwordError" class="text-red-500 text-sm"><?= $errors['password'] ?? '' ?></span>
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="w-full py-3 font-bold text-white rounded-md hover:bg-sky-600 focus:outline-none focus:ring-2 focus:ring-green-800" style="background-color:#1c4933;">
                            Se connecter
                        </button>
                    </div>
                    <div class="flex justify-center text-center text-black gap-2 mt-4">  
                       <p>Vous n'avez pas de compte ?</p>
                       <a href="direction.php" class="font-bold" style="color:#1c4933">S'inscrire</a>
                    </div>
                </form>
            </div>
        </div>
    </div>




</body>
</html>
