<?php
require_once '../../utils/autoload.php';
session_start();

$bookRepo = new BookRepository();
$userRepo = new UserRepository();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $livre = $bookRepo->getBookById($id);

    if (!$livre) {
        echo "Livre non trouvé.";
        exit();
    }

    // Récupérer les livres du même vendeur
    $books_by_seller = $bookRepo->getBooksBySellerId($livre->getIdSeller());
    $seller = $userRepo->getUserData($livre->getIdSeller());
    if ($seller) {
        $seller_prenom = $seller->getPrenom();
    } else {
        $seller_prenom = "Inconnu";
    }
} else {
    header('Location: ../../index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../../assets/js/script.js"></script>
    <link rel="stylesheet" href="../../assets/css/output.css">
    <title>Détails du Livre</title>
</head>

<body class="bg-primary-blue">

    <main>

        <?php include('../../frontend/components/header.php'); ?>

        <section class="flex justify-center items-center pt-8">
            <div class="p-4">
                <img src="../../assets/images/<?= htmlspecialchars($livre->getPhotoUrl()) ?>" alt="<?= htmlspecialchars($livre->getTitre()) ?>" class="w-44 rounded-lg shadow-lg">
            </div>

            <div class="w-1/2 p-4">
                <h2 class="text-3xl font-semibold text-gray-800 mb-4"><?= htmlspecialchars($livre->getTitre()) ?></h2>

                <h3 class="mt-2">description longue:</h3>
                <p class="text-gray-600 mt-2 flex-grow border border-gray-400 p-2 rounded"><?= htmlspecialchars($livre->getDescriptionLongue()) ?></p>


                <h3 class="mt-2">Genre:</h3>
        
                <p class="text-gray-600 mt-2 flex-grow border border-gray-400 p-2 rounded"><?= htmlspecialchars($livre->getGenre()) ?></p>

                <h3 class="mt-2">Etat:</h3>

                <p class="text-gray-600 mt-2 flex-grow border border-gray-400 p-2 rounded"><?= htmlspecialchars($livre->getEtat()); ?></p>
        
                <div class="flex items-center space-x-4">
                    <span class="text-xl font-semibold text-gray-800 mt-4">Prix :</span>
                    <span class="text-xl font-bold text-green-600 mt-4"><?= htmlspecialchars($livre->getPrix()) ?> €</span>
                </div>
                <a href="#" class="mt-4 inline-block bg-green-600 text-white py-2 px-6 rounded-lg hover:bg-green-700 transition duration-300">Acheter</a>
            </div>
        </section>

        <?php if (count($books_by_seller) > 1): ?>
            <h1 class="text-xl font-semibold text-gray-800 text-center mt-8"><?= htmlspecialchars($seller_prenom); ?> vend aussi ces livres</h1>
        <?php endif; ?>

        <section class="flex gap-10 pt-4 justify-center">
            <?php if (count($books_by_seller) > 1): ?>
                <?php foreach ($books_by_seller as $livre_associe): ?>
                    <?php if ($livre_associe->getId() != $livre->getId()): // Exclure le livre actuel ?>
                        <div class="max-w-xs bg-white rounded-lg shadow-lg overflow-hidden">
                            <img src="../../assets/images/<?= htmlspecialchars($livre_associe->getPhotoUrl()) ?>" alt="livre" class="w-full object-cover h-48">
                            <div class="p-4">
                            
                                <h2 class="text-xl font-semibold text-gray-800 text-center"><?= htmlspecialchars($livre_associe->getTitre()) ?></h2>

                                <h3 class="mt-2">description courte:</h3>
                              
                                <p class="text-gray-600 mt-2 flex-grow border border-gray-400 p-2 rounded"><?= htmlspecialchars($livre->getDescriptionLongue()) ?></p>
                                
                                <a href="detail.php?id=<?= $livre_associe->getId() ?>" class="block mt-4 text-center text-white bg-green-600 hover:bg-green-700 px-4 py-2 rounded-lg transition duration-300">Voir les détails</a>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-gray-600 font-bold text-xl ">Aucun autre livre vendu par ce vendeur.</p>
            <?php endif; ?>
        </section>

    </main>

    <footer class="pt-4">
        <?php include('../../frontend/components/footer.php'); ?>
    </footer>

</body>

</html>