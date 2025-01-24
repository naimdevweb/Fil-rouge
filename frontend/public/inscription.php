<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un Compte</title>
    <link rel="stylesheet" href="../../assets/css/output.css">
    <script type="module" src="../../assets/js/script.js" defer></script>
</head>

<body class="bg-gray-100 flex items-center justify-center">

    <main>
        <?php
        require_once '../../utils/autoload.php';
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
                    <label for="email" class="block text-sm font-medium text-gray-700">Votre email</label>
                    <input type="email" name="email" id="email" class="mt-1 block w-full border border-gray-600 rounded" required>
                </div>
                <div class="mb-4">
                    <label for="nom" class="block text-sm font-medium text-gray-700">Nom</label>
                    <input type="text" name="nom" id="nom" class="mt-1 block w-full" required>
                </div>
                <div class="mb-4">
                    <label for="prenom" class="block text-sm font-medium text-gray-700">Prénom</label>
                    <input type="text" name="prenom" id="prenom" class="mt-1 block w-full" required>
                </div>
                <div class="mb-4">
                    <label for="tel" class="block text-sm font-medium text-gray-700">Téléphone</label>
                    <input type="tel" name="tel" id="tel" class="mt-1 block w-full" required>
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
                    <input type="password" name="password" id="password" class="mt-1 block w-full" required>
                </div>
                <div class="mb-4">
                    <label for="role" class="block text-sm font-medium text-gray-700">Rôle</label>
                    <select name="role" id="role" class="mt-1 block w-full" required>
                        <option value="2">Vendeur</option>
                        <option value="3">Utilisateur</option>
                    </select>
                </div>
                <div class="mb-4" id="entreprise-info" style="display: none;">
                    <label for="adresse_entreprise" class="block text-sm font-medium text-gray-700">Adresse de l'entreprise</label>
                    <input type="text" name="adresse_entreprise" id="adresse_entreprise" class="mt-1 block w-full">
                    <label for="nom_entreprise" class="block text-sm font-medium text-gray-700">Nom de l'entreprise</label>
                    <input type="text" name="nom_entreprise" id="nom_entreprise" class="mt-1 block w-full">
                </div>
                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">S'inscrire</button>
                    <a href="./connexion.php" class="bg-blue-500 text-white px-4 py-2 rounded">Se connecter</a>
                </div>
            </form>
        </div>

        <script>
            document.getElementById('role').addEventListener('change', function() {
                var entrepriseInfo = document.getElementById('entreprise-info');
                if (this.value == '2') {
                    entrepriseInfo.style.display = 'block';
                } else {
                    entrepriseInfo.style.display = 'none';
                }
            });
        </script>

    </main>
</body>

</html>