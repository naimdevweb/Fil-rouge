<?php
// Démarrer la session
session_start();
require_once '../../db/connect_db.php'; 

// Vérifier si un identifiant de livre est passé dans l'URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Requête pour récupérer les détails du livre spécifique
    $sql = "SELECT l.photo_url, l.titre, l.description_longue, l.prix, l.id
            FROM livre l
            WHERE l.id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $livre = $stmt->fetch(PDO::FETCH_ASSOC);

    
    $sql_livres_associes = "SELECT l.photo_url, l.titre, l.description_courte, l.id
                            FROM livre l
                            WHERE l.id != :id"; 
    $stmt_livres_associes = $pdo->prepare($sql_livres_associes);
    $stmt_livres_associes->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt_livres_associes->execute();
    $livres_associes = $stmt_livres_associes->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Rediriger si aucun id n'est passé
    header('Location: ../../index.php');
    exit();
}
if (isset($_SESSION['user_prenom'])) {
    $user_prenom = $_SESSION['user_prenom'];
} else {
    $user_prenom = "Inconnu"; 
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../../assets/js/script.js"></script>
    <link rel="stylesheet" href="../../assets/css/output.css">
    <title>Détails du Livre</title>
</head>
<body class="bg-primary-blue"> 

<main>
    <!-- Inclusion de l'en-tête -->
    <?php include('../../frontend/components/header.php'); ?>

    
    <section class="flex justify-center items-center pt-8">
        <div class="p-4">
            <img src="../../uploads/<?= htmlspecialchars($livre['photo_url']) ?>" alt="<?= htmlspecialchars($livre['titre']) ?>" class="w-44 rounded-lg shadow-lg">
        </div>

        <div class="w-1/2 p-4">
            <h2 class="text-3xl font-semibold text-gray-800 mb-4"><?= htmlspecialchars($livre['titre']) ?></h2>
            <p class="text-gray-600 mb-4"><?= htmlspecialchars($livre['description_longue']) ?></p>
            <div class="flex items-center space-x-4">
                <span class="text-xl font-semibold text-gray-800">Prix :</span>
                <span class="text-xl font-bold text-green-600"><?= htmlspecialchars($livre['prix']) ?> €</span>
            </div>
            <a href="#" class="mt-4 inline-block bg-green-600 text-white py-2 px-6 rounded-lg hover:bg-green-700 transition duration-300">Acheter</a>
        </div>
    </section>

    
    <h1 class="text-xl font-semibold text-gray-800 text-center mt-8"><?= htmlspecialchars($user_prenom);?> vend aussi ces livres</h1>

    <section class="flex gap-10 pt-4 justify-center">
        <?php if (count($livres_associes) > 0): ?>
            <?php foreach ($livres_associes as $livre_associe): ?>
                <div class="max-w-xs bg-white rounded-lg shadow-lg overflow-hidden">
                    <img src="../../uploads/<?= htmlspecialchars($livre_associe['photo_url']) ?>" alt="livre" class="w-full object-cover h-48">
                    <div class="p-4">
                        <h2 class="text-xl font-semibold text-gray-800 text-center"><?= htmlspecialchars($livre_associe['titre']) ?></h2>
                        <p class="text-gray-600 mt-2"><?= htmlspecialchars($livre_associe['description_courte']) ?></p>
                        <a href="detail.php?id=<?= $livre_associe['id'] ?>" class="block mt-4 text-center text-white bg-green-600 hover:bg-green-700 px-4 py-2 rounded-lg transition duration-300">Voir les détails</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-gray-600 text-center">Aucun autre livre disponible pour le moment.</p>
        <?php endif; ?>
    </section>

</main>

<!-- Inclusion du pied de page -->
<footer class="pt-4">
    <?php include('../../frontend/components/footer.php'); ?>
</footer>

</body>
</html>
