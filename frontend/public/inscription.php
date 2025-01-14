<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un Compte</title>
    <link rel="stylesheet" href="../../assets/css/output.css">
    <script type="module" src="../../assets/js/script.js" defer></script>
</head>
<body class="bg-gray-100  flex items-center justify-center">

<main>
<?php
    session_start();
    
    if (isset($_SESSION["erreur"])) {
        echo "<p class='text-center text-off-red'>" . $_SESSION["erreur"] . "</p>";
        unset($_SESSION["erreur"]);
        session_destroy();
    } 
?>

    <div class="bg-white p-8 rounded-lg shadow-lg w-full sm:w-96">
        <h2 class="text-2xl font-semibold text-center mt-10 mb-4">Inscription</h2>
        
        <form action="../../backend/process_inscription.php" method="post">
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Vôtre email</label>
                <input type="email" name="user_email" id="user_email" placeholder="Vôtre email" required 
                       class="mt-2 p-3 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            
            <div class="mb-4">
                <label for="nom" class="block text-sm font-medium text-gray-700">Vôtre pseudo</label>
                <input type="text" name="user_nom" id="user_nom" placeholder="Vôtre nom" required 
                       class="mt-2 p-3 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label for="prenom" class="block text-sm font-medium text-gray-700">Vôtre prénom</label>
                <input type="text" name="user_prenom" id="user_prenom" placeholder="Vôtre prénom" required 
                       class="mt-2 p-3 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label for="telephone" class="block text-sm font-medium text-gray-700">Vôtre téléphone</label>
                <input type="tel" name="user_tel" id="user_tel" placeholder="06 30 30 10 21" required 
                       class="mt-2 p-3 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Sélection du rôle (Client ou Professionnel) -->
            <div class="mb-4">
                <label for="role" class="block text-sm font-medium text-gray-700">Vous êtes un</label>
                <select name="role" id="role" 
                        class="mt-2 p-3 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="1">Client</option>
                    <option value="2">Professionnel</option>
                </select>
            </div>

            <!-- Formulaire pour les professionnels (masqué par défaut) -->
            <div id="professionnelForm" class="hidden mt-4">
                <label for="adresse_entreprise" class="block text-sm font-medium text-gray-700">L'adresse de votre entreprise</label>
                <input type="text" name="adresse_entreprise" id="adresse_entreprise"
                       placeholder="L'adresse de votre entreprise"
                       class="mt-2 p-3 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">

                <label for="nom_entreprise" class="block text-sm font-medium text-gray-700 mt-4">Le nom de votre entreprise</label>
                <input type="text" name="nom_entreprise" id="nom_entreprise"
                       placeholder="Le nom de votre entreprise"
                       class="mt-2 p-3 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Mot de passe -->
            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700">Vôtre mot de passe</label>
                <input type="password" name="user_mdp" id="user_mdp" placeholder="Vôtre Mot de Passe" required 
                       class="mt-2 p-3 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <button type="submit" class="w-full p-3 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">Créer le Compte</button>
        </form>

        <div class="mt-4 text-center">
            <p class="text-sm text-gray-600">Déjà un compte ? <a href="./connexion.php" class="text-blue-500 hover:underline">Se connecter</a></p>
        </div>
    </div>
</main>



</body>
</html>
