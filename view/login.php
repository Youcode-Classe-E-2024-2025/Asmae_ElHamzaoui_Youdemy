<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <!-- Ajouter le CDN de Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
         /* Ajoutez un arrière-plan d'image pour le corps */
         body {
            background-color:white;}
        .logo {
            transform: translateX(110px); /* Déplace le logo de 3px vers la gauche */
        }
    </style>
</head>
<body>
    <div class="flex justify-center items-center min-h-screen">
        <div class="bg-indigo-950 p-12 rounded-lg shadow-lg w-full sm:w-[700px] grid grid-cols-1 sm:grid-cols-2 gap-8" style="background-color: #dadfdc;box-shadow: 0 4px 12px rgba(23, 60, 17, 0.62);">
            
            <!-- Section gauche (image et texte) -->
            <div class="flex flex-col justify-center items-center sm:items-start mb-10">
                <img src="../assets/images/logoB.png" alt="Logo" class="h-24 w-34 ml-24">
                <p class="font-bold sm:text-left text-black">Veuillez vous connecter pour accéder</p>
                <p class="font-bold sm:text-left text-black ml-20">à votre compte.</p>
            </div>

            <!-- Section droite (formulaire de connexion) -->
            <div>
                <form id="loginForm" action="../controller/loginController.php" method="POST" onsubmit="return validateLoginForm()">
                    <div class="mb-4">
                        <label for="email" class="block text-black">Email:</label>
                        <input type="email" id="email" name="email" class="w-full p-3 mt-1 border border-1 rounded-md focus:outline-none focus:ring-2 focus:ring-green-800" style="border-color:#1c4930" placeholder="Email" required>
                        <span id="emailError" class="text-red-500 text-sm"><?= $errors['email'] ?? '' ?></span>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="block text-black">Mot de passe:</label>
                        <input type="password" id="password" name="password" class="w-full p-3 mt-1 border border-1 rounded-md focus:outline-none focus:ring-2 focus:ring-green-800" style="border-color:#1c4930" placeholder="Mot de passe" required>
                        <span id="passwordError" class="text-red-500 text-sm"><?= $errors['password'] ?? '' ?></span>
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="w-full py-3 bg-sky-700 text-white rounded-md hover:bg-sky-600 focus:outline-none focus:ring-2 focus:ring-green-800" style="background-color:#1c4933;">
                            Se connecter
                        </button>
                    </div>
                    <div class="flex justify-center text-center text-black gap-2 mt-4">  
                       <p>Vous n'avez pas de compte ?</p>
                       <a href="direction.php"style="color:#1c4930;">S'inscrire</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

<script>
    function validateLoginForm() {
        let email = document.getElementById('email').value;
        let password = document.getElementById('password').value;
        let valid = true;

        // Réinitialiser les messages d'erreur
        document.getElementById('emailError').innerText = '';
        document.getElementById('passwordError').innerText = '';

        // Vérification de l'email
        if (email === '') {
            document.getElementById('emailError').innerText = "L'email est requis.";
            valid = false;
        }

        // Vérification du mot de passe
        if (password === '') {
            document.getElementById('passwordError').innerText = "Le mot de passe est requis.";
            valid = false;
        }

        return valid;
    }
</script>
</body>
</html>