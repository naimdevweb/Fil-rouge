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

    $livres_associes = $bookRepo->getAssociatedBooks($id);

    // Récupérer les livres du vendeur
    if ($livre->getId_seller()) {
        $books_by_seller = $bookRepo->getBooksBySellerId($livre->getId_seller());
        $seller = $userRepo->getUserData($livre->getId_seller());
        if ($seller) {
            $seller_prenom = $seller->getPrenom();
            // var_dump($seller_prenom);
            // die();
        } else {
            $seller_prenom = "Inconnu";
        }
    } else {
        $books_by_seller = [];
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
                <p class="text-gray-600 mb-4"><?= htmlspecialchars($livre->getDescription_longue()) ?></p>
                <div class="flex items-center space-x-4">
                    <span class="text-xl font-semibold text-gray-800">Prix :</span>
                    <span class="text-xl font-bold text-green-600"><?= htmlspecialchars($livre->getPrix()) ?> €</span>
                </div>
                <a href="#" class="mt-4 inline-block bg-green-600 text-white py-2 px-6 rounded-lg hover:bg-green-700 transition duration-300">Acheter</a>
            </div>
        </section>

        

        <h1 class="text-xl font-semibold text-gray-800 text-center mt-8"><?= htmlspecialchars($seller_prenom); ?> vend aussi ces livres</h1>

        <section class="flex gap-10 pt-4 justify-center">
            <?php if (count($livres_associes) > 0): ?>
                <?php foreach ($livres_associes as $livre_associe): ?>
                    <div class="max-w-xs bg-white rounded-lg shadow-lg overflow-hidden">
                        <img src="../../assets/images/<?= htmlspecialchars($livre_associe->getPhotoUrl()) ?>" alt="livre" class="w-full object-cover h-48">
                        <div class="p-4">
                            <h2 class="text-xl font-semibold text-gray-800 text-center"><?= htmlspecialchars($livre_associe->getTitre()) ?></h2>
                            <p class="text-gray-600 mt-2"><?= htmlspecialchars($livre_associe->getDescription_longue()) ?></p>
                            <a href="detail.php?id=<?= $livre_associe->getId() ?>" class="block mt-4 text-center text-white bg-green-600 hover:bg-green-700 px-4 py-2 rounded-lg transition duration-300">Voir les détails</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
            <?php endif; ?>
        </section>



       

    </main>


    <footer class="pt-4">
        <?php include('../../frontend/components/footer.php'); ?>
    </footer>

</body>

</html>