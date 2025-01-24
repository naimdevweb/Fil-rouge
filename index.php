<?php
// Démarrer la session
require_once './utils/autoload.php'; 
session_start();


$bookRepo = new BookRepository();
$livres = $bookRepo->getBooks();


if (isset($_SESSION['user'])) {
    $user_prenom = $_SESSION['user']->getPrenom();
   
} else {
    $user_prenom = "Inconnu"; 
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="./assets/js/script.js"></script>
    <link rel="stylesheet" href="./assets/css/output.css">
    <title>Page d'Accueil</title>
</head>
<body class="bg-primary-blue"> 

<main>
<?php include('./frontend/components/header.php'); ?>

<section>
    <img src="./assets/images/livre.jpg" alt="Livre" class="w-full h-auto max-h-80 object-cover">
</section>

<section class="text-center mt-4 uppercase">
    <h1 class="text-xl font-semibold text-gray-800">Livres Disponibles</h1>
</section>

<section class="flex flex-wrap gap-10 pt-4 justify-center">
    <?php if (count($livres) > 0): ?>
        <?php foreach ($livres as $livre): ?>
            <div class="max-w-xs w-full sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/5 bg-white rounded-lg shadow-lg overflow-hidden flex flex-col h-full">
    
            <img src="./assets/images/<?= htmlspecialchars($livre->getPhotoUrl()); ?>" alt="<?= htmlspecialchars($livre->getTitre()); ?>" class="flex-wrap h-48">

    <div class="p-4 flex flex-col justify-between flex-grow">
        <h2 class="text-xl font-semibold text-gray-800 text-center"><?= htmlspecialchars($livre->getTitre()) ?></h2>
        <h3 class="mt-2">Description Courte:</h3>
       
        <p class="text-gray-600 mt-2 flex-grow overflow-hidden"><?= htmlspecialchars($livre->getDescription_courte()) ?></p>
        <p class="text-gray-600 mt-2 flex-grow overflow-hidden"><?= htmlspecialchars($livre->getGenreNom()) ?></p>
        <a href="./frontend/public/detail.php?id=<?= $livre->getId()  ?>" class="block mt-4 text-center text-white bg-green-600 hover:bg-green-700 px-4 py-2 rounded-lg transition duration-300">En savoir plus</a>
    </div>
</div>

        <?php endforeach; ?>
    <?php else: ?>
        <p class="text-gray-600 text-center">Aucun livre disponible pour le moment.</p>
    <?php endif; ?>
</section>

</main>

<footer class="pt-4">
    <?php include('./frontend/components/footer.php'); ?>
</footer>

</body>
</html>
