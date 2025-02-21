<?php
// Démarrer la session
require_once './utils/autoload.php'; 
session_start();

$bookRepo = new BookRepository();
$livres = $bookRepo->getBooks();

if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    $user_prenom = $user->getPrenom();
} else {
    $user_prenom = "Inconnu"; 
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/output.css">
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <title>Page d'Accueil</title>
</head>
<body class="bg-primary-blue"> 

<main>
<?php
$genres = $bookRepo->getAllGenres();
$etats = $bookRepo->getAllEtats();
?>

<header class="bg-blue-600 text-white p-4">
    <div class="container mx-auto flex justify-between items-center">
        <div class="text-2xl font-semibold">
            Bookery
        </div>

        <div class="relative w-full max-w-md mx-auto">
            <form action="../../backend/process_search_bar.php" method="GET" class="w-full">
                <div class="relative">
                    <!-- Champ de recherche -->
                    <input 
                        type="text" 
                        name="query" 
                        class="w-full py-3 pl-12 pr-4 text-gray-700 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300" 
                        placeholder="Rechercher..." />
                </div>
            </form>
        </div>

        <nav class="flex space-x-6">
            <a href="./frontend/public/profil.php" class="hover:text-red-600">Compte</a>
            <a href="#" class="hover:text-gray-200" id="filter-toggle">Filtres</a>
            <a href="../../index.php" class="hover:text-gray-200">Livres</a>
            <a href="./frontend/public/panier.php" class="hover:text-gray-200">Panier</a>
        </nav>
    </div>
</header>

<!-- Barre déroulante des filtres -->
<div id="filter-bar" class="hidden bg-white shadow-lg rounded-lg p-4 mt-2">
    <form action="./backend/process_filtres.php" method="GET">
        <div class="mb-4">
            <label for="prix" class="block text-sm font-medium text-gray-700">Prix</label>
            <input type="text" name="prix" id="prix" class="mt-1 block w-full">
        </div>
        <div class="mb-4">
            <label for="genre" class="block text-sm font-medium text-gray-700">Genre</label>
            <select name="genre" id="genre" class="mt-1 block w-full">
                <option value="">Tous</option>
                <?php foreach ($genres as $genre): ?>
                    <option value="<?= htmlspecialchars($genre->getNomGenre()) ?>"><?= htmlspecialchars($genre->getNomGenre()) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-4">
            <label for="etat" class="block text-sm font-medium text-gray-700">État</label>
            <select name="etat" id="etat" class="mt-1 block w-full">
                <option value="">Tous</option>
                <?php foreach ($etats as $etat): ?>
                    <option value="<?= htmlspecialchars($etat->getNomEtat()) ?>"><?= htmlspecialchars($etat->getNomEtat()) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-300">Appliquer</button>
        </div>
    </form>
</div>

<section>
    <img src="./assets/images/livre.jpg" alt="Livre" class="w-full h-auto max-h-80 object-cover">
</section>

<section class="text-center mt-4 uppercase">
    <h1 class="text-xl font-semibold text-gray-800">Livres Disponibles</h1>
</section>

<section class="flex flex-wrap gap-6 pt-4 justify-center">
    <?php if (count($livres) > 0): ?>
        <?php foreach ($livres as $livre): ?>
            <div class="max-w-xs w-full sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/5 bg-white rounded-lg shadow-lg overflow-hidden flex flex-col h-[400px]">
                <!-- Image avec affichage normal -->
                <img src="./assets/images/<?= htmlspecialchars($livre->getPhotoUrl()); ?>" 
                     alt="<?= htmlspecialchars($livre->getTitre()); ?>" 
                     class="h-[200px] w-full object-contain">

                     <!-- Contenu de la carte -->
                     <div class="p-4 flex flex-col justify-between flex-grow">
                         <h2 class="text-lg font-semibold text-gray-800 text-center"><?= htmlspecialchars($livre->getTitre()) ?></h2>
                         
                         <p class="text-gray-600 mt-2 flex-grow border border-gray-400 p-2 rounded text-sm line-clamp-3">
                             <?= htmlspecialchars($livre->getDescriptionCourte()) ?>
                            </p>
                            
                            <a href="./frontend/public/detail.php?id=<?= $livre->getId() ?>" 
                                   class="block mt-4 text-center text-white bg-green-600 hover:bg-green-700 px-4 py-2 rounded-lg transition duration-300">
                                    En savoir plus
                                </a>
                    
                </div>
            </div>
            <?php endforeach; ?>
            <?php else: ?>
                <p class="text-gray-600 text-center">Aucun livre disponible pour le moment.</p>
                <?php endif; ?>
            </section>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('filter-toggle').addEventListener('click', function() {
        var filterBar = document.getElementById('filter-bar');
        if (filterBar.classList.contains('hidden')) {
            filterBar.classList.remove('hidden');
        } else {
            filterBar.classList.add('hidden');
        }
    });
});
</script>

</body>
</html>