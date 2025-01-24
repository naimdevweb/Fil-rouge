<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un Compte</title>
    <link rel="stylesheet" href="../../assets/css/output.css">
</head>
<body class="bg-gray-100  flex items-center justify-center">
<main>
<?php
        session_start();
       
        
        
        if (isset($_SESSION["mdp"])) {
            echo "<p class='text-center text-red-600'>" . $_SESSION["mdp"] . "</p>";
            unset($_SESSION["mdp"]);
        }
    ?>
    <div class="bg-white p-8 rounded-lg shadow-lg w-full sm:w-96">
       
        <h2 class="text-2xl font-semibold text-center mt-10 mb-4">connexion</h2>
        
        <form action="../../backend/process_connexion.php" method="post">
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Vôtre email</label>
                <input type="email" name="user_email" id="user_email" placeholder="Vôtre email" required 
                       class="mt-2 p-3 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            
          

            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700">Vôtre mot de passe</label>
                <input type="password" name="user_mdp" id="user_mdp" placeholder="Vôtre Mot de Passe" required 
                       class="mt-2 p-3 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <button type="submit" class="w-full p-3 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">Se connecter</button>
        </form>

        <div class="mt-4 text-center">
            <p class="text-sm text-gray-600">Inscrivez-vous <a href="./inscription.php" class="text-blue-500 hover:underline">S'inscrire</a></p>
        </div>
       
    </div>
</main>

</body>
</html>
