<?php
include_once '../../utils/autoload.php';
session_start();

$searchResults = isset($_SESSION['search_results']) ? $_SESSION['search_results'] : [];

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats de la recherche</title>
    <link rel="stylesheet" href="../../assets/css/output.css">
</head>
<body class="bg-gray-100">

<main class="max-w-7xl mx-auto p-8">

    <h1 class="text-3xl font-semibold text-gray-800 mb-4">Résultats de la recherche</h1>

    <section class="bg-white p-6 rounded-lg shadow-lg mb-8">
        <?php if (!empty($searchResults)): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($searchResults as $book): ?>
                    <div class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col h-full">
                        <img src="../../assets/images/<?= htmlspecialchars($book->getPhotoUrl()); ?>" alt="<?= htmlspecialchars($book->getTitre()); ?>" class="h-48 w-full object-contain">
                        <div class="p-4 flex flex-col justify-between flex-grow">
                            <h3 class="text-xl font-semibold text-gray-800 mb-2 text-center"><?= htmlspecialchars($book->getTitre()); ?></h3>
                            <p class="text-gray-700 mb-2 font-bold">description courte : <br> <?= htmlspecialchars($book->getDescriptionCourte()); ?></p>
                            <p class="text-gray-700 mb-2 font-bold mt-4">Prix: <?= htmlspecialchars($book->getPrix()); ?> €</p>
                            <div class="mt-2">
                                <span class="inline-block bg-blue-100 text-blue-800 text-l px-2 py-1 rounded-full">Genre: <?= htmlspecialchars($book->getGenre()); ?></span>
                                <span class="inline-block bg-green-100 text-green-800 text-l px-2 py-1 rounded-full">État: <?= htmlspecialchars($book->getEtat()); ?></span>
                            </div>
                            <a href="../public/detail.php?id=<?= $book->getId() ?>" class="block mt-4 text-center text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg transition duration-300">En savoir plus</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-gray-700">Aucun livre trouvé.</p>
        <?php endif; ?>
    </section>

</main>

</body>
</html>