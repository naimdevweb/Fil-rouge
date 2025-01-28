<?php
require_once '../../utils/autoload.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$bookRepo = new BookRepository();
$acheteur_id = $_SESSION['user_id'];
$panierItems = $bookRepo->getCartItems($acheteur_id);
// var_dump($panierItems);
// die();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/output.css">
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <title>Mon Panier</title>
</head>
<body class="bg-gray-100">
<?php include('../../frontend/components/header.php'); ?>
<main class="max-w-7xl mx-auto p-8">

    <h1 class="text-3xl font-semibold text-gray-800 mb-4">Mon Panier</h1>

    <section class="bg-white p-6 rounded-lg shadow-lg mb-8">
        <?php if (!empty($panierItems)): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($panierItems as $item): ?>
                    <div class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col h-full">
                        <img src="../../assets/images/<?= htmlspecialchars($item->getPhotoUrl()); ?>" alt="<?= htmlspecialchars($item->getTitre()); ?>" class="h-48 w-full object-contain">
                        <div class="p-4 flex flex-col justify-between flex-grow">
                            <h3 class="text-xl font-semibold text-gray-800 mb-2 text-center"><?= htmlspecialchars($item->getTitre()); ?></h3>
                            <p class="text-gray-700 mb-2 font-bold">Prix: <?= htmlspecialchars($item->getPrix()); ?> €</p>
                            <a href="#" class="block mt-4 text-center text-white bg-green-600 hover:bg-green-700 px-4 py-2 rounded-lg transition duration-300">Acheter</a>
                           <form action="../../backend/process_delete_achat.php">
                            <a href="#" class="block mt-4 text-center text-white bg-red-600 hover:bg-red-700 px-4 py-2 rounded-lg transition duration-300">Supprimer</a>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-gray-700">Votre panier est vide.</p>
        <?php endif; ?>
    </section>

</main>

</body>
</html>