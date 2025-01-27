<?php

session_start();
require_once '../../utils/autoload.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../frontend/public/connexion.php");
    exit();
}


$userRepo = new UserRepository();
$bookRepo = new BookRepository();

$user_id = $_SESSION['user_id'];
$user = $userRepo->getUserData($user_id);
$vendeur = $userRepo->getVendeurByUserId($user_id);
$livres = $bookRepo->getBooksBySellerId($user_id);
// var_dump($user);
// die();

if (!$user) {
    echo "Utilisateur non trouvé.";
    exit();
}



$role_id = $user->getRoleId();
$user_prenom = $user->getPrenom();



if ($role_id == 1) {
    $users = $userRepo->getAllUsers();
    $livres = $bookRepo->getBooks();
}

$isApproved = false;
if ($role_id == 2) {
    $vendeur = $userRepo->getVendeurByUserId($_SESSION['user_id']);
    $isApproved = $vendeur ? $vendeur->isApproved() : false;
}
// var_dump($livres);
// die();
$roleName = $userRepo->getRoleNameById($user->getRoleId());
$users = $userRepo->getAllUsersExceptAdmin();


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Utilisateur</title>
    <link rel="stylesheet" href="../../assets/css/output.css"> 
</head>
<body class="bg-gray-100">

<?php include('../../frontend/components/header.php'); ?>

<main class="max-w-7xl mx-auto p-8">

<?php if ($role_id == 1): ?>
    <!-- Page Admin -->
    <?php include('../components/admin.php'); ?>
<?php endif; ?>

<?php if ($role_id == 2): ?>
    <!-- Page Professionnel -->
    <?php
    $vendeur = $userRepo->getVendeurByUserId($user_id);
    $isApproved = $vendeur ? $vendeur->isApproved() : null;
    ?>
    <?php if ($isApproved === true): ?>
        <?php include('../components/professionel.php'); ?>
    <?php elseif ($isApproved === false): ?>
        <?php
        // Mettre à jour le rôle de l'utilisateur à client (3)
        $userRepo->updateUserRole($user_id, 3);
        $_SESSION['user'] = $userRepo->getUserData($user_id);
        $role_id = 3;
        ?>
        <section class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <h1 class="text-3xl font-semibold text-gray-800"><?= htmlspecialchars($user->getPrenom()); ?></h1>
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Votre demande a été refusée</h2>
            <p class="text-gray-700 mt-2">
                Votre demande pour devenir un vendeur professionnel a été refusée. Vous avez maintenant accès à la page client.
            </p>
            <div class="flex justify-end space-x-4 mt-6">
                <a href="./modifier.php" class="bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-300">
                    Modifier
                </a>
                <a href="../../backend/process_deconnexion.php" class="bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700 transition duration-300">
                    Déconnexion
                </a>
            </div>
        </section>
        <?php include('../components/client.php'); ?>
    <?php else: ?>
        <section class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <h1 class="text-3xl font-semibold text-gray-800"><?= htmlspecialchars($user->getPrenom()); ?></h1>
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Votre demande est en attente d'approbation</h2>
            <p class="text-gray-700 mt-2">
                Votre demande pour devenir un vendeur professionnel est en attente d'approbation par l'administrateur. Vous ne pouvez pas poster d'annonces tant que votre demande n'a pas été acceptée.
            </p>
            <div class="flex justify-end space-x-4 mt-6">
                <a href="./modifier.php" class="bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-300">
                    Modifier
                </a>
                <a href="../../backend/process_deconnexion.php" class="bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700 transition duration-300">
                    Déconnexion
                </a>
            </div>
        </section>
    <?php endif; ?>
<?php endif; ?>

<?php if ($role_id == 3): ?>
   


<section class="bg-white rounded-lg shadow-lg p-6 mb-8">
    <h3 class="text-2xl font-semibold text-gray-800 mb-4"><?= htmlspecialchars($user_prenom) ?>
    <h2 class="text-2xl font-semibold text-gray-800 mb-4"> Bienvenue sur votre espace Client</h2>
    <p class="text-gray-700 mt-2">
        Explorez une large sélection de livres à acheter ou à échanger. Consultez les annonces des professionnels et 
        des autres clients pour trouver ce qui vous intéresse.
    </p>
    <div class="flex justify-end space-x-4 mt-6">
        <a href="./modifier.php" 
           class="bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-300">
            Modifier
        </a>
        <a href="../../backend/process_deconnexion.php" 
           class="bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700 transition duration-300">
            Déconnexion
        </a>
    </div>
</section>

<section class="bg-white rounded-lg shadow-lg p-6 mb-8">
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Mes Achats</h2>
    <p class="text-gray-700 mb-4">
        Ici, vous trouverez l’historique de tous vos achats .
    </p>
    <!-- Section des achats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      
        <div class="bg-gray-100 rounded-lg shadow p-4 text-center">
           
        </div>
        
    </div>
</section>
<?php endif; ?>
</main>
</body>
</html>