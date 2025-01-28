<?php
require_once '../../utils/autoload.php';
session_start();

$filteredBooks = isset($_SESSION['filtered_books']) ? $_SESSION['filtered_books'] : [];
// var_dump($filteredBooks);
// die();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Livres</title>
    <link rel="stylesheet" href="../../assets/css/output.css">
</head>
<?php include('../../frontend/components/header.php'); ?>
<body class="bg-gray-100">

<main class="max-w-7xl mx-auto p-8">
    <!-- Titre principal -->
    <h1 class="text-xl font-bold text-gray-800 mb-8 text-center">Livres Disponibles</h1>

    <!-- Section des livres -->
    <section class="bg-white p-8 rounded-lg shadow-lg">
        <?php if (!empty($filteredBooks)): ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($filteredBooks as $book): ?>
                    <!-- Carte individuelle -->
                    <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                        <!-- Image -->
                        <img src="../../assets/images/<?= htmlspecialchars($book->getPhotoUrl()); ?>" 
                             alt="<?= htmlspecialchars($book->getTitre()); ?>" 
                             class=" h-56 object-cover rounded-t-lg">
                        
                        <!-- Contenu -->
                        <div class="p-4">
                            <h3 class="text-2xl font-semibold text-gray-800 mb-2"><?= htmlspecialchars($book->getTitre()); ?></h3>
                            <p class="text-gray-600 mb-4"><?= htmlspecialchars($book->getDescriptionCourte()); ?></p>
                            <div class="flex justify-between items-center">
                                <span class="text-green-600 font-bold"><?= htmlspecialchars($book->getPrix()); ?> €</span>
                                <span class="text-gray-500 text-sm"><?= htmlspecialchars($book->getEtat()); ?></span>
                            </div>
                        </div>
                        
                        <!-- Bouton -->
                        <div class="p-4 text-center">
                            <a href="../public/detail.php?id=<?= $book->getId(); ?>" 
                               class="inline-block w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-300">
                                Voir plus
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-gray-700 text-center text-lg">Aucun livre trouvé.</p>
        <?php endif; ?>
    </section>
</main>

</body>
</html>