<?php
$bookRepo = new BookRepository();
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
            <a href="./profil.php" class="hover:text-red-600">Compte</a>
            <a href="#" class="hover:text-gray-200" id="filter-toggle">Filtres</a>
            <a href="../../index.php" class="hover:text-gray-200">Livres</a>
            <a href="../public/panier.php" class="hover:text-gray-200">Panier</a>
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

<script>
document.getElementById('filter-toggle').addEventListener('click', function() {
    var filterBar = document.getElementById('filter-bar');
    if (filterBar.classList.contains('hidden')) {
        filterBar.classList.remove('hidden');
    } else {
        filterBar.classList.add('hidden');
    }
});
</script>