<?php
// Démarrer la session
session_start();
require_once './db/connect_db.php'; 

// Requête SQL pour récupérer tous les livres
$sql = "SELECT l.photo_url, l.titre, l.description_courte, l.id
        FROM livre l";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$livres = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    
    <img src="<?= "./uploads/" . htmlspecialchars($livre['photo_url']) ?>" alt="livre" class="w-full object-cover h-48">

    <div class="p-4 flex flex-col justify-between flex-grow">
        <h2 class="text-xl font-semibold text-gray-800 text-center"><?= htmlspecialchars($livre['titre']) ?></h2>
        <h3 class="mt-2">Description:</h3>
       
        <p class="text-gray-600 mt-2 flex-grow overflow-hidden"><?= htmlspecialchars($livre['description_courte']) ?></p>
        <a href="./frontend/public/detail.php?id=<?= $livre['id'] ?>" class="block mt-4 text-center text-white bg-green-600 hover:bg-green-700 px-4 py-2 rounded-lg transition duration-300">En savoir plus</a>
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
